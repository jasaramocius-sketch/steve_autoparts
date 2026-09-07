<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Page;
use App\Models\Product;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function index()
    {
        $page = \App\Models\Page::where('slug', 'cart')->first();
        $cart = session('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        $cartItems = session()->get('cart', []);
        $couponData = $this->recomputeCoupon($cart) ?? [];
        $couponDiscount = $couponData['discount'] ?? 0;
        return view('cart.index', compact('cart', 'total', 'cartItems', 'page', 'couponData', 'couponDiscount'));
    }

    public function add(Request $request)
    {
        $cart = session('cart', []);

        $id = $request->product_id;
        $qty = max((int)$request->input('qty', 1), 1);

        if (isset($cart[$id])) {

            $cart[$id]['qty'] += $qty;

        } else {

            $cart[$id] = [
                'id' => $id,
                'name' => $request->product_name,
                'price' => $request->product_price,
                'image' => $request->product_image,
                'qty' => $qty,
            ];
        }

        session()->put('cart', $cart);
        $this->recomputeCoupon($cart);

        // Buy Now
        if ($request->has('buy_now')) {
            return redirect()->route('cart')
                ->with('success', 'Product added to cart!');
        }

        // AJAX request
        if ($request->ajax()) {
            $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => count($cart),
                'cart_total' => currency_format($total)
            ]);
        }

        // Normal request
        return back()->with('success', 'Product added to cart!');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);
        $this->recomputeCoupon($cart);

        if ($request->ajax()) {
            $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart!',
                'cart_count' => count($cart),
                'cart_total' => currency_format($total)
            ]);
        }

        return back()->with('success', 'Product removed from cart!');
    }

    public function removeSelected(Request $request)
    {
        $ids = json_decode($request->product_ids, true) ?? [];
        $cart = session('cart', []);
        foreach ($ids as $id) {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
        $this->recomputeCoupon($cart);
        $count = count($ids);
        return back()->with('success', "$count item(s) removed from cart!");
    }
    public function updateQuantity(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (!isset($cart[$id])) {

        return response()->json([
            'success' => false
        ]);

    }

    $qty = max((int)$request->quantity,1);

    $cart[$id]['qty']=$qty;

    session()->put('cart',$cart);
    $this->recomputeCoupon($cart);

    $itemSubtotal=$cart[$id]['price']*$qty;

    $cartTotal=array_sum(array_map(function($item){

        return $item['price']*$item['qty'];

    },$cart));

    return response()->json([

        'success'=>true,

        'qty'=>$qty,

        'itemSubtotal'=>currency_format($itemSubtotal),

        'cartTotal'=>currency_format($cartTotal)

    ]);
}
    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string|max:50']);
        $code = strtoupper(trim($request->coupon_code));
        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }
        if (!$coupon->isValid()) {
            return back()->with('error', 'This coupon is no longer valid.');
        }

        $cart = session('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));

        if ($coupon->min_order_amount > 0 && $subtotal < $coupon->min_order_amount) {
            return back()->with('error', 'Minimum order amount for this coupon is ' . currency_format($coupon->min_order_amount) . '.');
        }

        $discount = $coupon->calculateDiscount($subtotal);
        session([
            'coupon' => [
                'code'     => $coupon->code,
                'discount' => $discount,
                'type'     => $coupon->type,
                'value'    => $coupon->value,
            ]
        ]);

        return back()->with('success', 'Coupon applied! You saved ' . currency_format($discount) . '.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }

    /**
     * Recompute the applied coupon against the CURRENT cart.
     * Re-fetches the coupon from DB, re-validates (validity, capacity, min-order)
     * and re-calculates the discount on the current subtotal.
     * Used on every cart change and as the final authority in paymentSubmit.
     */
    private function recomputeCoupon(array $cart): ?array
    {
        if (session()->missing('coupon')) {
            return null;
        }

        $code = session('coupon')['code'] ?? null;
        if (!$code) {
            session()->forget('coupon');
            return null;
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            session()->forget('coupon');
            return null;
        }

        $discount = $coupon->calculateDiscount($subtotal);

        if ($discount <= 0) {
            session()->forget('coupon');
            return null;
        }

        $data = [
            'code'     => $coupon->code,
            'discount' => $discount,
            'type'     => $coupon->type,
            'value'    => $coupon->value,
        ];
        session()->put('coupon', $data);

        return $data;
    }

    public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {

        $cart[$id]['qty']++;

    } else {

        $cart[$id] = [

            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'qty'   => 1,

        ];
    }

    session()->put('cart', $cart);

    if ($request->ajax()) {
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => count($cart),
            'cart_total' => currency_format($total)
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart!');
}

    public function checkout()
    {
        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        $couponData = $this->recomputeCoupon($cart) ?? [];
        $couponDiscount = $couponData['discount'] ?? 0;
        $addresses = auth()->user()->addresses()->latest()->get();
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        $selectedVehicleId = session('selected_vehicle_id');
        return view('checkout.index', compact('cart', 'total', 'addresses', 'vehicles', 'selectedVehicleId', 'couponData', 'couponDiscount'));
    }

    public function checkoutSubmit(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $address = \App\Models\Address::findOrFail($request->address_id);
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $vehicleId = null;
        if ($request->filled('vehicle_id')) {
            $vehicle = Vehicle::where('user_id', auth()->id())->where('id', $request->vehicle_id)->first();
            $vehicleId = $vehicle ? $vehicle->id : null;
        }
        session(['checkout_vehicle_id' => $vehicleId]);

        session([
            'billing_info' => [
                'name' => $address->full_name,
                'email' => auth()->user()->email,
                'phone' => $address->phone,
                'address' => $address->address,
                'city' => $address->city,
                'state' => $address->state,
                'country' => $address->country,
                'zip_code' => $address->zip_code,
            ]
        ]);

        return redirect()->route('checkout.delivery-info');
    }

    public function deliveryInfo()
    {
        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
        $billing = session('billing_info');
        if (!$billing) {
            return redirect()->route('checkout');
        }
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return view('checkout.delivery-info', compact('cart', 'total', 'billing'));
    }

    public function deliveryInfoSubmit(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|in:free,pickup',
        ]);

        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $shippingCosts = ['free' => 0, 'pickup' => 0];
        $shippingCost = $shippingCosts[$request->shipping_method];

        session([
            'shipping_info' => [
                'method' => $request->shipping_method,
                'cost' => $shippingCost,
            ]
        ]);

        return redirect()->route('checkout.payment');
    }

    public function payment()
    {
        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
        $billing = session('billing_info');
        if (!$billing) {
            return redirect()->route('checkout');
        }
        $shipping = session('shipping_info');
        if (!$shipping) {
            return redirect()->route('checkout.delivery-info');
        }
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        $shippingCost = $shipping['cost'];
        $couponData = $this->recomputeCoupon($cart) ?? [];
        $couponDiscount = $couponData['discount'] ?? 0;
        $grandTotal = max($total + $shippingCost - $couponDiscount, 0);
        $shippingMethod = $shipping['method'];
        return view('checkout.payment', compact('cart', 'total', 'shippingCost', 'grandTotal', 'shippingMethod', 'couponData', 'couponDiscount'));
    }

    public function paymentSubmit(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,card,paypal',
        ]);

        $paymentDetails = null;
        if ($request->payment_method === 'card' && $request->filled('card_number')) {
            $digits = preg_replace('/\D/', '', $request->card_number);
            $paymentDetails = json_encode([
                'card_last_four' => substr($digits, -4),
                'card_number'    => substr($request->card_number, 0, 6) . '****' . substr($digits, -4),
            ]);
        }

        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $billing = session('billing_info');
        $shipping = session('shipping_info');

        if (!$billing || !$shipping) {
            return redirect()->route('checkout');
        }

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        $shippingCost = $shipping['cost'] ?? 0;
        $couponData = $this->recomputeCoupon($cart) ?? [];
        $couponDiscount = $couponData['discount'] ?? 0;
        $grandTotal = max($total + $shippingCost - $couponDiscount, 0);

        // Save to database
        $dbOrder = \Illuminate\Support\Facades\DB::transaction(function () use ($request, $cart, $billing, $shipping, $grandTotal, $shippingCost, $paymentDetails, $couponData, $couponDiscount, $total) {

            $orderNumber = 'ORD' . strtoupper(uniqid());

            $dbOrder = \App\Models\Order::create([
                'user_id'            => auth()->id(),
                'vehicle_id'         => session('checkout_vehicle_id'),
                'order_number'       => $orderNumber,
                'total_amount'       => $grandTotal,
                'status'             => 'pending',
                'payment_method'     => $request->payment_method,
                'payment_status'     => in_array($request->payment_method, ['card', 'paypal'], true) ? 'paid' : 'unpaid',
                'payment_details'    => $paymentDetails,
                'delivery_type'      => $shipping['method'] ?? 'free',
                'shipping_fee'       => $shippingCost,
                'tax'                => 0,
                'coupon_code'        => $couponData['code'] ?? null,
                'coupon_discount'    => $couponDiscount,
                'additional_info'    => $request->input('additional_info'),
                'shipping_details'   => json_encode($billing),
            ]);

            // Proportional coupon split: each item's share = discount * (line subtotal / order subtotal)
            $distributedDiscount = 0.0;
            $lineCount = count($cart);
            foreach ($cart as $i => $item) {
                $lineSubtotal = $item['price'] * $item['qty'];
                $itemDiscount = 0.0;
                if ($couponDiscount > 0 && $total > 0) {
                    $itemDiscount = round($couponDiscount * ($lineSubtotal / $total), 2);
                }
                // Last item absorbs rounding remainder so line discounts sum exactly to the order discount
                if ($i === $lineCount - 1 && $couponDiscount > 0) {
                    $itemDiscount = round($couponDiscount - $distributedDiscount, 2);
                }
                $distributedDiscount += $itemDiscount;

                \App\Models\OrderItem::create([
                    'order_id'        => $dbOrder->id,
                    'product_id'      => $item['id'],
                    'qty'             => $item['qty'],
                    'price'           => $item['price'],
                    'coupon_discount' => $itemDiscount,
                ]);
            }

            // Increment coupon usage count
            if (!empty($couponData['code']) && $couponDiscount > 0) {
                $coupon = \App\Models\Coupon::where('code', $couponData['code'])->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            return $dbOrder;
        });

        \App\Helpers\NotificationHelper::orderPlaced($dbOrder);

        // Build session data for the confirmation page
        $order = [
            'id'             => '#' . $dbOrder->order_number,
            'db_id'          => $dbOrder->id,
            'date'           => $dbOrder->created_at->format('d M, Y'),
            'total'          => $grandTotal,
            'subtotal'       => $total,
            'status'         => 'Pending',
            'payment_method' => $request->payment_method,
            'coupon_code'    => $couponData['code'] ?? null,
            'coupon_discount' => $couponDiscount,
            'customer_name'  => $billing['name'] ?? auth()->user()->name,
            'customer_email' => $billing['email'] ?? auth()->user()->email,
            'customer_phone' => $billing['phone'] ?? '',
            'address'        => ($billing['address'] ?? '') . ', ' . ($billing['city'] ?? '') . ', ' . ($billing['country'] ?? ''),
            'items'          => array_values(array_map(fn($item) => [
                'name'  => $item['name'],
                'qty'   => $item['qty'],
                'price' => $item['price'],
            ], $cart)),
        ];

        session()->put('last_order', $order);

        // Clear checkout session data
        session()->forget('cart');
        session()->forget('billing_info');
        session()->forget('shipping_info');
        session()->forget('checkout_vehicle_id');
        session()->forget('coupon');

        return redirect()->route('checkout.confirmed');
    }

    public function orderConfirmed()
    {
        $order = session('last_order');

        // Fallback: if session expired, try loading the user's latest order
        if (!$order && auth()->check()) {
            $dbOrder = \App\Models\Order::where('user_id', auth()->id())
                ->latest()
                ->with('items.product')
                ->first();

            if ($dbOrder) {
                $billing = json_decode($dbOrder->shipping_details, true) ?? [];
                $order = [
                    'id'             => '#' . $dbOrder->order_number,
                    'db_id'          => $dbOrder->id,
                    'date'           => $dbOrder->created_at->format('d M, Y'),
                    'total'          => $dbOrder->total_amount,
                    'status'         => ucfirst($dbOrder->status),
                    'payment_method' => $dbOrder->payment_method,
                    'customer_name'  => $billing['name'] ?? auth()->user()->name,
                    'customer_email' => $billing['email'] ?? auth()->user()->email,
                    'customer_phone' => $billing['phone'] ?? '',
                    'address'        => ($billing['address'] ?? '') . ', ' . ($billing['city'] ?? '') . ', ' . ($billing['country'] ?? ''),
                    'items'          => $dbOrder->items->map(fn($i) => [
                        'name'  => $i->product->name ?? 'Product #' . $i->product_id,
                        'qty'   => $i->qty,
                        'price' => $i->price,
                    ])->toArray(),
                ];
            }
        }

        if (!$order) {
            return redirect()->route('home');
        }

        return view('checkout.order-confirmed', compact('order'));
    }

    public function miniCart()
    {
        $cart = session('cart', []);
        $cartCount = count($cart);
        $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return view('partials.mini-cart', compact('cart', 'cartCount', 'cartTotal'));
    }
}
