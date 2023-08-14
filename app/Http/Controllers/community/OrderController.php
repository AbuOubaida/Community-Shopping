<?php

namespace App\Http\Controllers\community;

use App\Http\Controllers\Controller;
use App\Models\communities;
use App\Models\community_order_from_shop;
use App\Models\order;
use App\Models\Order_product;
use Illuminate\Contracts\View\Factory;
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
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
//            dd($me,$userComm);
            $shopOrders = community_order_from_shop::leftJoin('order_products as op','op.id','community_order_from_shops.order_id')
                ->leftJoin('orders as o','o.order_id','op.order_id')
                ->leftJoin('shop_infos as si','si.id','community_order_from_shops.shop_id')
                ->where('community_order_from_shops.status',1)
                ->where('op.order_status',11)
                ->where('community_order_from_shops.community_id',$userComm->id)
                ->select('op.order_quantity','op.order_status','o.c_name','o.c_phone','o.delivery_address','o.delivery_person_id','si.shop_name','si.shop_phone','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*')->get();
//            dd($shopOrders);
//            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
//                ->leftJoin("products as p",'p.id','order_products.product_id')
//                ->leftJoin('orders as o','o.order_id','order_products.order_id')
//                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')->where('order_products.vendor_id',$me->id)->where(function ($query){
//                    $query->where('Order_products.order_status',11);
//                    $query->orWhere('Order_products.order_status',12);
//                })->get();
//            dd($primaryOrders);
            return view('back-end.community.orders.sending.shop.order-list',compact('headerData','shopOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function ShopOrderView($orderID)
    {
        $orderID = decrypt($orderID);//community_order_from_shops id
        $me = Auth::user();
        $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
        $singleOrder = community_order_from_shop::leftJoin('order_products as op','op.id','community_order_from_shops.order_id')
            ->leftJoin('orders as o','o.order_id','op.order_id')
            ->leftJoin('shop_infos as si','si.id','community_order_from_shops.shop_id')
            ->leftJoin('communities as delivery_person','delivery_person.id','o.delivery_person_id')
//            ->where('community_order_from_shops.status',1)
//            ->where('op.order_status',11)
            ->where('community_order_from_shops.community_id',$userComm->id)
            ->where('community_order_from_shops.id',$orderID)
            ->select('op.order_id as product_order_id','op.order_quantity','op.delivery_quantity','op.order_status','o.invoice_id','o.c_name','o.c_email','o.c_phone','o.delivery_address','o.delivery_person_id','delivery_person.owner_id as d_c_owner_id','delivery_person.community_name','delivery_person.community_type','delivery_person.community_phone','delivery_person.community_email','delivery_person.home as d_home','delivery_person.village as d_village','delivery_person.word as d_word','delivery_person.union as d_union','delivery_person.upazila as d_upazila','delivery_person.district as d_district','delivery_person.division as d_division','delivery_person.country as d_country','si.shop_name','si.shop_phone','si.shop_email','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*')->first();
        if ($singleOrder != null)
        {
            community_order_from_shop::where('id',$orderID)->where('seen_status',"!=",1)->update(['seen_status'=>1]);
        }
        return view("back-end/community/orders/sending/order-single-view",compact('singleOrder'));
    }

    public function shopOrderAccepted(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'ref'   => ['required'],
                    'qnt'   => ['required','numeric'],
                ]);
                extract($request->post());
                $c_o_f_s_id = decrypt($ref);//community_order_from_shops id
                $me = Auth::user();
                $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
                if ($order = community_order_from_shop::where('id',$c_o_f_s_id)->first())
                {
                    community_order_from_shop::where('id',$c_o_f_s_id)->where('community_id',$userComm->id)->update([
                        'status'    =>  2,
                    ]);

                    Order_product::where('id',$order->order_id)->update([
                        'delivery_quantity' => $qnt,
                        'order_status'      => 12,
                        'updated_by'        => $me->id,
                    ]);
                    return back()->with('success','Data update successfully!');
                }
                return back()->with('error','Order not found!');
            }
            return back()->with('error','Something went wrong!');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function shopAcceptedOrderList()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
//            dd($me,$userComm);
            $shopOrders = community_order_from_shop::leftJoin('order_products as op','op.id','community_order_from_shops.order_id')
                ->leftJoin('orders as o','o.order_id','op.order_id')
                ->leftJoin('shop_infos as si','si.id','community_order_from_shops.shop_id')
                ->where('community_order_from_shops.status',2)
                ->where('op.order_status',12)
                ->where('community_order_from_shops.community_id',$userComm->id)
                ->select('op.order_quantity','op.order_status','o.c_name','o.c_phone','o.delivery_address','o.delivery_person_id','si.shop_name','si.shop_phone','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*')->get();
            return view('back-end.community.orders.sending.shop.order-list',compact('headerData','shopOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function deliveryDirectCustomer(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'ref'   => ['required'],
                ]);
                extract($request->post());
                $c_o_f_s_id = decrypt($ref);//community_order_from_shops id
                $me = Auth::user();
                $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
                if ($order = community_order_from_shop::where('id',$c_o_f_s_id)->first())
                {
                    community_order_from_shop::where('id',$c_o_f_s_id)->where('community_id',$userComm->id)->update([
                        'status'    =>  3,//3=delivery
                    ]);

                    Order_product::where('id',$order->order_id)->update([
                        'order_status'      => 6,//6=received delivery man
                        'updated_by'        => $me->id,
                    ]);
                    return back()->with('success','Data update successfully!');
                }
                return back()->with('error','Order not found!');
            }
            return back()->with('error','Something went wrong!');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function sendAdmin(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'ref'   => ['required'],
                ]);
                extract($request->post());
                $c_o_f_s_id = decrypt($ref);//community_order_from_shops id
                $me = Auth::user();
                $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
                if ($order = community_order_from_shop::where('id',$c_o_f_s_id)->first())
                {
                    community_order_from_shop::where('id',$c_o_f_s_id)->where('community_id',$userComm->id)->update([
                        'status'    =>  3,//3=delivery
                    ]);

                    Order_product::where('id',$order->order_id)->update([
                        'order_status'      => 3,//3= vendor regional admin
                        'updated_by'        => $me->id,
                    ]);
                    return back()->with('success','Data update successfully!');
                }
                return back()->with('error','Order not found!');
            }
            return back()->with('error','Something went wrong!');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

}
