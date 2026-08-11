<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
        // 1. Check if the order exists at a raw database level (ignoring models/scopes)
        $isNumeric = is_numeric($idOrNumber);
        $rawQuery = $isNumeric
            ? \DB::table('orders')->where('id', $idOrNumber)->first()
            : \DB::table('orders')->where('order_number', $idOrNumber)->first();

        if (!$rawQuery) {
            dd("Database Error: There is absolutely NO row with id/order_number = {$idOrNumber} in your orders table.");
        }

        // 2. If it exists, let's check if it's soft-deleted or hidden by a scope
        try {
            $orderQuery = Order::with(['items.product', 'user']);
            $order = $isNumeric
                ? $orderQuery->findOrFail($idOrNumber)
                : $orderQuery->where('order_number', $idOrNumber)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            dd([
                "Message" => "Eloquent cannot find this order. It is likely soft-deleted or restricted by a Model Scope.",
                "Database Row Data Found" => $rawQuery
            ]);
        } catch (\Exception $e) {
            dd("Other Error: " . $e->getMessage());
        }

        // 3. If it passes everything, let's see if it successfully loads the view
        $userId = auth()->id();
        $reviewedSlugs = [];
        foreach ($order->items as $item) {
            if (!$item->product || empty($item->product->reviews_data)) {
                continue;
            }
            foreach ($item->product->reviews_data as $review) {
                if (($review['user_id'] ?? null) == $userId && !($review['deleted'] ?? false)) {
                    $reviewedSlugs[$item->product->id] = true;
                    break;
                }
            }
        }

        return view('user.orders.show', compact('order', 'reviewedSlugs'));
    }
    public function destroy($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    public function tracking(Request $request)
    {
        $order = null;

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
        }

        return view('user.orders.tracking', compact('order'));
    }

    public function invoice($id)
    {
        // Fetch the order along with its item lines
        $order = Order::with('items.product')->findOrFail($id);

        // 1. Load the blade view file and pass the order data to it
        $pdf = Pdf::loadView('user.orders.invoice', compact('order'));
        
        // 2. Set the paper size to A4 (optional but recommended for invoices)
        $pdf->setPaper('a4', 'portrait');

        // 3. Force the browser to directly download the PDF file
        return $pdf->stream('Invoice-' . ($order->order_number ?? $order->id) . '.pdf');
    }
}
