<?php

namespace App\Http\Controllers\community;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\Order_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function myOrder()
    {
        $headerData = ['app'=>str_replace("_"," ",config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'My Order List'];
        $me = Auth::user();
        $orders = order::leftJoin('users as u','u.id','orders.customer_id')
            ->select(DB::raw("(select count(id) from order_products as op where op.order_id = orders.order_id) as nop"),'u.name as customer_name','orders.*')->where('orders.customer_id',$me->id)->get();
        return view('back-end.community.orders.my-order.order-list',compact('headerData','orders'));
    }

    public function orderSingle($orderID)
    {
//        dd(route("my.order.list"));
        $headerData = ['app'=>str_replace("_"," ",config("app.name")) ,'role'=>'User','title'=>'My Order view'];
        $cID = Auth::user()->id;
        $order = order::where('order_id',$orderID)->where('customer_id',$cID)->first();
        $order_products = Order_product::leftJoin("products as p",'p.id','order_products.product_id')->where('order_products.order_id',$orderID)->where('order_products.customer_id',$cID)->select('p.p_name as product_name','order_products.*')->get();
        return view("back-end.community.orders.my-order.order-single-view",compact('order','order_products','headerData'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        //
    }

    public function ShopOrder ()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
//            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
//                ->leftJoin("products as p",'p.id','order_products.product_id')
//                ->leftJoin('orders as o','o.order_id','order_products.order_id')
//                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')->where('order_products.vendor_id',$me->id)->where(function ($query){
//                    $query->where('Order_products.order_status',11);
//                    $query->orWhere('Order_products.order_status',12);
//                })->get();
//            dd($primaryOrders);
//            return view('back-end.community.orders.sending.order-list',compact('headerData','primaryOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
}
