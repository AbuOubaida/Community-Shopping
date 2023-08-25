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
use function Psy\sh;

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

    public function ShopRequestList ()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
//            dd($me,$userComm);
            $shopOrders = community_order_from_shop::leftJoin('order_products as op','op.id','community_order_from_shops.order_id')
                ->leftJoin('orders as o','o.order_id','op.order_id')
                ->leftJoin('shop_infos as si','si.id','community_order_from_shops.shop_id')
                ->leftJoin('order_statuses as os','op.order_status','os.status_value')
                ->where('community_order_from_shops.status',1)
                ->where('op.order_status',11)
                ->where('community_order_from_shops.community_id',$userComm->id)
                ->select('op.order_quantity','op.order_status','o.c_name','o.c_phone','o.delivery_address','o.delivery_person_id','si.shop_name','si.shop_phone','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*','os.status_name','os.status_value','os.title','os.badge')->get();
            return view('back-end.community.orders.sending.shop.order-list',compact('headerData','shopOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function adminRequestList ()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
            $adminOrders = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('users as admin','order_products.updated_by','admin.id')
                ->leftJoin('users as customer','order_products.customer_id','customer.id')
                ->leftJoin('products as p','p.id','order_products.product_id')
                ->leftJoin('order_statuses as os','order_products.order_status','os.status_value')
                ->where('o.delivery_person_id',$userComm->id)
                ->where('order_products.order_status',4)//4=Waiting for Delivery Community
                ->select('o.invoice_id','customer.name as customer_user_name','customer.phone as customer_user_phone','o.c_name','o.c_phone','o.c_email','o.delivery_address','admin.name as admin_name','admin.phone as admin_phone','admin.home as admin_home','admin.village as admin_village','admin.word as admin_word','admin.union as admin_union','admin.upazila as admin_upazila','admin.district as admin_district','admin.division as admin_division','admin.country as admin_country','os.status_name','os.status_value','os.title','os.badge','order_products.*')->get();
//            dd($adminOrders);
            return view('back-end.community.orders.sending.admin.order-list',compact('headerData','adminOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function adminAcceptedList ()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
            $adminOrders = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('users as admin','order_products.updated_by','admin.id')
                ->leftJoin('users as customer','order_products.customer_id','customer.id')
                ->leftJoin('products as p','p.id','order_products.product_id')
                ->leftJoin('order_statuses as os','order_products.order_status','os.status_value')
                ->where('o.delivery_person_id',$userComm->id)
                ->where('order_products.order_status',5)//5=Delivery Community Received order
                ->select('o.invoice_id','customer.name as customer_user_name','customer.phone as customer_user_phone','o.c_name','o.c_phone','o.c_email','o.delivery_address','admin.name as admin_name','admin.phone as admin_phone','admin.home as admin_home','admin.village as admin_village','admin.word as admin_word','admin.union as admin_union','admin.upazila as admin_upazila','admin.district as admin_district','admin.division as admin_division','admin.country as admin_country','os.status_name','os.status_value','os.title','os.badge','order_products.*')->get();
//            dd($adminOrders);
            return view('back-end.community.orders.sending.admin.order-list',compact('headerData','adminOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function waitingCustomerReceivingList ()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
            $adminOrders = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('users as admin','order_products.updated_by','admin.id')
                ->leftJoin('users as customer','order_products.customer_id','customer.id')
                ->leftJoin('products as p','p.id','order_products.product_id')
                ->leftJoin('order_statuses as os','order_products.order_status','os.status_value')
                ->where('o.delivery_person_id',$userComm->id)
                ->where('order_products.order_status',6)//6=Community Request to Customer for receive product
                ->select('o.invoice_id','customer.name as customer_user_name','customer.phone as customer_user_phone','o.c_name','o.c_phone','o.c_email','o.delivery_address','admin.name as admin_name','admin.phone as admin_phone','admin.home as admin_home','admin.village as admin_village','admin.word as admin_word','admin.union as admin_union','admin.upazila as admin_upazila','admin.district as admin_district','admin.division as admin_division','admin.country as admin_country','os.status_name','os.status_value','os.title','os.badge','order_products.*')->get();
//            dd($adminOrders);
            return view('back-end.community.orders.sending.admin.order-list',compact('headerData','adminOrders'));
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
            ->leftJoin('order_statuses as os','op.order_status','os.status_value')
//            ->where('community_order_from_shops.status',1)
//            ->where('op.order_status',11)
            ->where('community_order_from_shops.community_id',$userComm->id)
            ->where('community_order_from_shops.id',$orderID)
            ->select('op.order_id as product_order_id','op.order_quantity','op.delivery_quantity','op.order_status','o.invoice_id','o.c_name','o.c_email','o.c_phone','o.delivery_address','o.delivery_person_id','delivery_person.owner_id as d_c_owner_id','delivery_person.community_name','delivery_person.community_type','delivery_person.community_phone','delivery_person.community_email','delivery_person.home as d_home','delivery_person.village as d_village','delivery_person.word as d_word','delivery_person.union as d_union','delivery_person.upazila as d_upazila','delivery_person.district as d_district','delivery_person.division as d_division','delivery_person.country as d_country','si.shop_name','si.shop_phone','si.shop_email','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*','os.status_name','os.status_value','os.title','os.badge')->first();
        if ($singleOrder != null)
        {
            community_order_from_shop::where('id',$orderID)->where('seen_status',"!=",1)->update(['seen_status'=>1]);
        }
        return view("back-end/community/orders/sending/shop/order-single-view",compact('singleOrder'));
    }
    public function AdminOrderView($orderID)
    {
        $orderID = decrypt($orderID);//community_order_from_shops id

        $me = Auth::user();
        $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
        $singleOrder = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
            ->leftJoin('users as admin','order_products.updated_by','admin.id')
            ->leftJoin('users as customer','order_products.customer_id','customer.id')
            ->leftJoin('products as p','p.id','order_products.product_id')
            ->leftJoin('order_statuses as os','order_products.order_status','os.status_value')
            ->where('o.delivery_person_id',$userComm->id)
            ->where('order_products.id',$orderID)
            ->where(function ($query){
                $query->where('order_products.order_status',4);//4=Waiting for Delivery Community
                $query->orWhere('order_products.order_status',5);//5=Received delivery community
                $query->orWhere('order_products.order_status',6);//6=Community Request to Customer for receive product
                $query->orWhere('order_products.order_status',7);//6=Customer Received Product
            })
            ->select('o.invoice_id','o.c_name','o.c_email','o.c_phone','o.delivery_address','admin.name as admin_name','admin.phone as admin_phone','admin.home as admin_home','admin.village as admin_village','admin.word as admin_word','admin.union as admin_union','admin.upazila as admin_upazila','admin.district as admin_district','admin.division as admin_division','admin.country as admin_country','order_products.*','os.status_name','os.status_value','os.title','os.badge')->first();
        return view("back-end/community/orders/sending/admin/order-single-view",compact('singleOrder'));
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
    public function communityAcceptedOrderAdmin(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'ref'   => ['required'],
                ]);
                extract($request->post());
                $orderID = decrypt($ref);//order id
                $me = Auth::user();
                $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
                $order = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')->where('o.delivery_person_id',$userComm->id)->where('order_products.id',$orderID)->where('order_products.order_status',4)->select('order_products.*')->first();//4 Waiting for Delivery Community
                if ($order)
                {
                    $nou = $order->number_of_updated+1;
                    Order_product::where('id',$order->id)->update([
                        'order_status'      => 5,//Received delivery community
                        'updated_by'        => $me->id,
                        'number_of_updated' => $nou,
                        'updated_at'        => now(),
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
                ->leftJoin('order_statuses as os','op.order_status','os.status_value')
                ->where('community_order_from_shops.status',2)
                ->where('op.order_status',12)
                ->where('community_order_from_shops.community_id',$userComm->id)
                ->select('op.order_quantity','op.order_status','o.c_name','o.c_phone','o.delivery_address','o.delivery_person_id','si.shop_name','si.shop_phone','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*','os.status_name','os.status_value','os.title','os.badge')->get();
            return view('back-end.community.orders.sending.shop.order-list',compact('headerData','shopOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function waitingCustomerAcceptanceList()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
            $shopOrders = community_order_from_shop::leftJoin('order_products as op','op.id','community_order_from_shops.order_id')
                ->leftJoin('orders as o','o.order_id','op.order_id')
                ->leftJoin('shop_infos as si','si.id','community_order_from_shops.shop_id')
                ->leftJoin('order_statuses as os','op.order_status','os.status_value')
                ->where('community_order_from_shops.status',3)
                ->where('op.order_status',6)
                ->where('community_order_from_shops.community_id',$userComm->id)
                ->select('op.order_quantity','op.order_status','o.c_name','o.c_phone','o.delivery_address','o.delivery_person_id','si.shop_name','si.shop_phone','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*','os.status_name','os.status_value','os.title','os.badge')->get();
            return view('back-end.community.orders.sending.shop.order-list',compact('headerData','shopOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function shopCompleteOrderList()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'Request form shop List'];
            $me = Auth::user();
            $userComm = communities::where('owner_id',$me->id)->where('status',1)->first();
            $shopOrders = community_order_from_shop::leftJoin('order_products as op','op.id','community_order_from_shops.order_id')
                ->leftJoin('orders as o','o.order_id','op.order_id')
                ->leftJoin('shop_infos as si','si.id','community_order_from_shops.shop_id')
                ->leftJoin('order_statuses as os','op.order_status','os.status_value')
                ->where('community_order_from_shops.status',3)
                ->where('community_order_from_shops.community_id',$userComm->id)
                ->where(function ($query){
                    $query->where('op.order_status',7);
                    $query->orWhere('op.order_status',8);
                })
                ->select('op.order_quantity','op.order_status','o.c_name','o.c_phone','o.delivery_address','o.delivery_person_id','si.shop_name','si.shop_phone','si.open_at','si.closed_at','si.home as shop_home','si.village as shop_vill','si.word as shop_word','si.union as shop_union','si.upazila as shop_upazilla','si.district as shop_dist','si.division as shop_div','si.country as shop_country','community_order_from_shops.*','os.status_name','os.status_value','os.title','os.badge')->get();
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
                        'order_status'      => 6,//6=community request to customer
                        'updated_by'        => $me->id,
                    ]);
                    return back()->with('success','Data update successfully!');
                }
                elseif ($order = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')->where('o.delivery_person_id',$userComm->id)->where('order_products.id',$c_o_f_s_id)->where('order_products.order_status',5)->select('order_products.*')->first())//4 Waiting for Delivery Community
                {
                    $nou = $order->number_of_updated+1;
                    Order_product::where('id',$order->id)->update([
                        'order_status'      => 6,//Community Request to Customer for receive product
                        'updated_by'        => $me->id,
                        'number_of_updated' => $nou,
                        'updated_at'        => now(),
                    ]);
                    return back()->with('success','Data update successfully!');
                }
                else
                {
                    return back()->with('error','Order not found!');
                }
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
                        'order_status'      => 14,//14= vendor site community request to admin
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
