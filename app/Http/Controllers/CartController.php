<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('frontend.cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Session::forget('coupon');
        Session::forget('discounts');
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price,)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        Session::forget('coupon');
        Session::forget('discounts');
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1; // Corrected to use $product->qty
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        Session::forget('coupon');
        Session::forget('discounts');
        $product = Cart::instance('cart')->get($rowId);

        // If quantity is 1, remove the item from the cart
        if ($product->qty <= 1) {
            Cart::instance('cart')->remove($rowId);
        } else {
            // Otherwise, decrease the quantity
            $qty = $product->qty - 1;
            Cart::instance('cart')->update($rowId, $qty);
        }

        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Session::forget('coupon');
        Session::forget('discounts');
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }
    public function empty_cart()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->input('coupon_code');

        if (empty($coupon_code)) {
            return redirect()->back()->with('error', 'Coupon code cannot be empty!');
        }

        $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());

        $coupon = Coupon::where('code', $coupon_code)
            ->where('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', $subtotal)
            ->first();

        if (!$coupon) {
            \Log::error("Invalid coupon code: $coupon_code");
            return redirect()->back()->with('error', 'Invalid coupon code!');
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value
        ]);

        $this->calculateDiscount();
        return redirect()->back()->with('success', 'Coupon code applied successfully!');
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if (Session::has('coupon')) {
            $subtotal = (float) str_replace(',', '', Cart::instance('cart')->subtotal());
            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
                $discount = ($subtotal * Session::get('coupon')['value']) / 100;
            }

            $subtotalAfterDiscount = $subtotal - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
                'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
                'total' => number_format(floatval($totalAfterDiscount), 2, '.', ''),
            ]);
        }
    }
    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back()->with('success', 'Coupon code removed successfully!');
    }
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $addresses = Address::where('user_id', Auth::id())
            ->where('is_default', 1)
            ->first();
        return view('frontend.checkout', compact('addresses'));
    }
    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('is_default', true)->first();

        if (!$address) {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'Bangladesh'; // Add appropriate value for country
            $address->user_id = $user_id;
            $address->is_default = true;
            $address->save();
        }
        $this->setAmountForCheckout();
        // dd(Session::get('checkout'));
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country; // Add country assignment
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }
        $validated = $request->validate([
            'mode' => 'required|in:card,paypal,cod',
        ]);
        if ($request->mode == "card") {
            // Handle card payment
        } elseif ($request->mode == "paypal") {
            // Handle PayPal payment
        } elseif ($request->mode == "cod") {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode; // Fixed 'mde' to 'mode'
            $transaction->status = "pending";
            $transaction->save();
        }
        // Clear cart and session data
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);
        return redirect()->route('cart.order.confirmation');
    }
    public function setAmountForCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }
    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::findOrFail(Session::get('order_id'));
            return view('frontend.order_confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
