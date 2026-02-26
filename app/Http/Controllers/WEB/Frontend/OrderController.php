<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use Auth;
class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with('orderProducts')->where('order_phone', $user->phone)->latest()->get();
// dd($orders);
        return view('frontend2.pages.order-history', compact('orders'));
    }

    public function order_list($phone)
    {
        $orders = Order::with('orderProducts')->where('order_phone', $phone)->latest()->get();
      	$order_inv = Order::with('orderProducts')->where('order_phone', $phone)->first();

        return view('frontend2.pages.order-history', compact('orders', 'order_inv'));
    }
   	public function thanks_page($phone)
     {
       	$order_inv = Order::with(['orderProducts.product'])->where('order_phone', $phone)->latest()->first();
        return view('frontend.order.thanks', compact('order_inv'));
    }


    public function show($id)
    {
        $order = Order::with('user', 'orderProducts')->findOrFail($id);
      //dd($order);

        // $view = view('frontend.order.show', compact('order'))->render();
        // return response()->json([
        //     'status' => true,
        //     'html' => $view,
        // ]);
        return view('frontend2.pages.order-details', compact('order'));
    }

    public function print($id)
    {
        $order = Order::with('user', 'orderProducts')->findOrFail($id);

        return view('frontend.order.print', compact('order'));
    }
}
