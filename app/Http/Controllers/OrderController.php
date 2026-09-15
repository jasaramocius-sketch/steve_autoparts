<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $orders = $query
            ->orderBy($sortBy, $sortDir)
            ->paginate($request->get('per_page', 10))
            ->withQueryString();

        return view('admin.orders.index', compact(
            'orders',
            'sortBy',
            'sortDir'
        ));
    }

    public function show($idOrNumber)
    {
        $user = auth()->user();

        $isNumeric = is_numeric($idOrNumber);
        try {
            $orderQuery = Order::with(['items.product', 'user']);
            $order = $isNumeric
                ? $orderQuery->findOrFail($idOrNumber)
                : $orderQuery->where('order_number', $idOrNumber)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        // Users can only view their own orders
        if ($order->user_id !== $user->id) {
            abort(403, 'You are not authorized to view this order.');
        }

        // If it passes everything, let's see if it successfully loads the view
        $userId = auth()->id();
        $reviewedSlugs = [];
        foreach ($order->items as $item) {
            if (! $item->product || empty($item->product->reviews_data)) {
                continue;
            }
            foreach ($item->product->reviews_data as $review) {
                if (($review['user_id'] ?? null) == $userId && ! ($review['deleted'] ?? false)) {
                    $reviewedSlugs[$item->product->id] = true;
                    break;
                }
            }
        }

        return view('user.orders.show', compact('order', 'reviewedSlugs'));
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    public function tracking(Request $request)
    {
        $order = null;
        $user = auth()->user();

        if ($request->isMethod('post')) {
            $request->validate([
                'order_number' => 'required|string',
            ]);

            $order = Order::with(['items.product', 'user'])
                ->where(function ($q) use ($request) {
                    $q->where('order_number', $request->order_number)
                        ->orWhere('id', $request->order_number);
                })
                ->first();

            // Users can only track their own orders
            if ($order && $order->user_id !== $user->id) {
                abort(403, 'You are not authorized to view this order.');
            }
        }

        return view('user.orders.tracking', compact('order'));
    }

    public function invoice($id)
    {
        $user = auth()->user();

        // Fetch the order along with its item lines
        $order = Order::with('items.product')->findOrFail($id);

        // Users can only download invoices for their own orders
        if ($order->user_id !== $user->id) {
            abort(403, 'You are not authorized to view this order.');
        }

        // Load the blade view file and pass the order data to it
        $pdf = Pdf::loadView('user.orders.invoice', compact('order'));

        // Set the paper size to A4 (optional but recommended for invoices)
        $pdf->setPaper('a4', 'portrait');

        // Force the browser to directly download the PDF file
        return $pdf->stream('Invoice-'.($order->order_number ?? $order->id).'.pdf');
    }
}
