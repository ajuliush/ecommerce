<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price,)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rawId)
    {
        $product = Cart::instance('cart')->get($rawId);
        $qyt = $product->id + 1;
        Cart::instance('cart')->update($rawId, $qyt);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rawId)
    {
        $product = Cart::instance('cart')->get($rawId);
        $qyt = $product->id - 1;
        Cart::instance('cart')->update($rawId, $qyt);
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
}
