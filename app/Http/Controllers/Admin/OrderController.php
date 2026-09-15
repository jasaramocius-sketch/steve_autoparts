<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['id', 'order_number', 'total_amount', 'total', 'status', 'payment_status', 'created_at']) ? $request->sort_by : 'created_at';
        $sortDir = $request->sort_dir === 'asc' ? 'asc' : 'desc';
        $perPage = in_array((int) $request->per_page, [10, 20, 50, 100]) ? (int) $request->per_page : 10;

        $query = Order::with('user');

        $statusFilter = $request->status;
        if (in_array($statusFilter, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'], true)) {
            $query->where('status', $statusFilter);
        }

        $paymentStatusFilter = $request->payment_status;
        if (in_array($paymentStatusFilter, ['unpaid', 'paid', 'refunded'], true)) {
            $query->where('payment_status', $paymentStatusFilter);
        }

        $orders = $query->orderBy($sortBy, $sortDir)->paginate($perPage);
        $orders->appends($request->query())->onEachSide(1);

        return view('admin.orders.index', compact('orders', 'sortBy', 'sortDir', 'statusFilter', 'paymentStatusFilter'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'nullable|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,refunded',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;

        $newPaymentStatus = $request->has('payment_status') && $request->filled('payment_status')
            ? $request->payment_status
            : $order->payment_status;

        $rawDetails = $order->payment_details;
        $details = is_array($rawDetails) ? $rawDetails : (is_string($rawDetails) ? json_decode($rawDetails, true) : null);
        $details = is_array($details) ? $details : [];
        $existingTxnId = $details['transaction_id'] ?? '';

        $update = [];
        if ($request->has('status') && $request->filled('status')) {
            $update['status'] = $request->status;
        }
        if ($request->has('payment_status') && $request->filled('payment_status')) {
            $update['payment_status'] = $request->payment_status;
        }

        // Transaction ID only makes sense when the payment is Paid.
        $paidOrder = $newPaymentStatus === 'paid' || ($order->payment_status === 'paid' && ! $request->has('payment_status'));

        if ($paidOrder && $request->has('transaction_id')) {
            $transactionId = trim((string) $request->transaction_id);

            if ($transactionId === '') {
                // No-op: an existing transaction ID is never cleared.
            } elseif ($existingTxnId === $transactionId) {
                // Same value re-submitted — nothing to do.
            } elseif ($existingTxnId !== '') {
                // Already set — cannot be changed (one-time).
                return back()->withErrors(['transaction_id' => 'Transaction ID is already set for this order and can only be set once.'])->withInput();
            } else {
                // Check uniqueness across all other orders.
                $duplicate = Order::where('id', '!=', $order->id)
                    ->where('payment_details->transaction_id', $transactionId)
                    ->exists();

                if ($duplicate) {
                    return back()->withErrors(['transaction_id' => 'This Transaction ID is already used by another order.'])->withInput();
                }

                $details['transaction_id'] = $transactionId;
                $update['payment_details'] = json_encode($details);
            }
        }

        if (! empty($update)) {
            $order->update($update);
        }

        NotificationHelper::orderStatusChanged($order, $oldStatus);

        return redirect()->route('admin.orders.show', $id)->with('success', 'Order updated successfully.');
    }
}
