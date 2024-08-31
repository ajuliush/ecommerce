<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view order', only: ['index']),
            new Middleware('permission:edit order', only: ['edit']),
            new Middleware('permission:create order', only: ['create']),
            new Middleware('permission:delete order', only: ['destroy']),
            new Middleware('permission:show order', only: ['show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->roles[0]->name == 'user') {
            $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
            return view('frontend.user.orders', compact('orders'));
        } elseif (Auth::user()->roles[0]->name == 'superadmin') {
            $query = Order::query();

            if ($request->has('search')) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            }

            $orders = $query->orderBy('id', 'DESC')->paginate(10);
            return view('backend.order.index', compact('orders'));
        }
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
        if (Auth::user()->roles[0]->name == 'user') {
            $order = Order::with(['orderItems' => function ($query) {
                $query->orderBy('id')->paginate(12);
            }, 'transaction'])->where('user_id', Auth::user()->id)->findOrFail($id);

            return view('frontend.user.order-details', compact('order'));
        } elseif (Auth::user()->roles[0]->name == 'superadmin') {
            $order = Order::with(['orderItems' => function ($query) {
                $query->orderBy('id')->paginate(12);
            }, 'transaction'])->findOrFail($id);

            return view('backend.order.show', compact('order'));
        }
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