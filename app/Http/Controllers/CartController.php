<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;


class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        $cartItems = session()->get('cart', []);
        return view('cart', compact('cart', 'total','cartItems'));
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
        $count = count($ids);
        return back()->with('success', "$count item(s) removed from cart!");
    }
    public function updateQuantity(Request $request, $id)
    {
        $quantity = intval($request->input('quantity', 1));
        if ($quantity < 1) $quantity = 1;

        // 1. Get the current cart from session
        $cart = session()->get('cart', []);

        // 2. Check if item exists, then update quantity
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $quantity;
            $cart[$id]['quantity'] = $quantity; // support both keys for compatibility
            
            // Save the updated cart back to the session
            session()->put('cart', $cart);

            // Calculate new subtotal for this specific item
            $itemSubtotal = $cart[$id]['price'] * $quantity;

            // Calculate overall cart total
            $cartTotal = array_reduce($cart, function($carry, $item) {
                $itemQty = $item['qty'] ?? $item['quantity'] ?? 1;
                return $carry + ($item['price'] * $itemQty);
            }, 0);

            return response()->json([
                'success' => true,
                'itemSubtotal' => currency_format($itemSubtotal),
                'cartTotal' => currency_format($cartTotal)
            ]);
        }

        return response()->json(['success' => false], 400);
    }
    public function addToCart(Request $request, $id)
    {
        // Fetch product from database
        $product = Product::findOrFail($id);
        
        $cart = session()->get('cart', []);

        // If item already exists, increment quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // If item doesn't exist, add it with quantity = 1
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1, // <--- MAKE SURE THIS LINE EXISTS
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return view('checkout', compact('cart', 'total'));
    }

    public function checkoutSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ]);

        $cart = session('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        $orders = session('orders', []);

        $newOrder = [
            'id' => '#ORD' . rand(10000, 99999),
            'date' => date('d M, Y'),
            'total' => $total,
            'status' => 'Pending',
            'customer_name' => $request->input('name'),
            'customer_email' => $request->input('email'),
            'customer_phone' => $request->input('phone'),
            'address' => $request->input('address') . ', ' . $request->input('city') . ', ' . $request->input('country'),
            'items' => array_values(array_map(fn($item) => [
                'name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price']
            ], $cart))
        ];

        $orders[] = $newOrder;
        
        session([
            'orders' => $orders,
            'user_logged_in' => true,
            'user_profile' => [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
            ]
        ]);

        session()->forget('cart');

        return redirect()->route('user.dashboard')->with('success', 'Order placed successfully! Welcome to your dashboard.');
    }
}
