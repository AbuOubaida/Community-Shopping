<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\Order_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
//Admin Order
    public function adminOrderList()
    {
        try {
            $user = Auth::user();
            $order_products = Order_product::leftJoin('users as u','u.id','Order_products.vendor_id')
                ->leftJoin('shop_infos as si','u.id','si.owner_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('u.name as vendor','si.shop_name','si.status as shop_active_status','si.shop_phone','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','Order_products.*')
                ->where('o.district','like',"%$user->district%")
                ->get();
            return view("back-end/admin/orders/admin/order-list",compact('order_products'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function communityOrderList()
    {
        try {
            $user = Auth::user();
            $order_products = Order_product::leftJoin('users as u','u.id','order_products.vendor_id')
                ->leftJoin('shop_infos as si','u.id','si.owner_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('u.name as vendor','si.shop_name','si.status as shop_active_status','si.shop_phone','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','Order_products.*')
                ->where('o.district','like',"%$user->district%")
                ->where(function ($query){
                    $query->where('order_products.order_status',14);
                    $query->orWhere('order_products.order_status',3);
                })
                ->get();
//            dd($order_products);
            return view("back-end/admin/orders/community/order-list",compact('order_products'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function allOrderList()
    {
        try {
            $user = Auth::user();
            $order_products = Order_product::leftJoin('users as u','u.id','order_products.vendor_id')
                ->leftJoin('shop_infos as si','u.id','si.owner_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('u.name as vendor','si.shop_name','si.status as shop_active_status','si.shop_phone','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','Order_products.*')
                ->get();
//            dd($order_products);
            return view("back-end/admin/orders/all/order-list",compact('order_products'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function OrderView($oID)
    {
        try {
            $order_id = decrypt($oID);
            $user = Auth::user();
            $order_product = Order_product::leftJoin('users as vendor','vendor.id','Order_products.vendor_id')
                ->leftJoin('shop_infos as si','vendor.id','si.owner_id')
                ->leftJoin('users as customer', 'customer.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('communities as community', 'community.id','o.delivery_person_id')
                ->leftJoin('users as community_user', 'community_user.id','community.creater_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('vendor.name as vendor','vendor.phone as vendor_phone','si.shop_name','si.status as shop_active_status','si.shop_phone','si.shop_email','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','customer.name as customer','customer.phone as customer_phone','o.c_name as receiver_name','o.c_phone as receiver_phone','o.c_email as receiver_email','o.delivery_address','o.order_status as order_active_status','o.shipping_charge','o.payment_method','o.district as delivery_district','community_user.name as community_user_name','community_user.phone as community_user_phone','community.community_name','community.community_type','community.community_phone','community.community_email','community.village as community_village','community.union as community_union','community.upazila as community_upazila','community.district as community_district','community.division as community_division','community.country as community_country','Order_products.*')
                ->where('Order_products.id',$order_id)
                ->first();
            return view("back-end/admin/orders/shop/order-single-view",compact('order_product'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function communityOrderView($oID)
    {
        try {
            $order_id = decrypt($oID);
            $user = Auth::user();
            $order_product = Order_product::leftJoin('users as vendor','vendor.id','Order_products.vendor_id')
                ->leftJoin('shop_infos as si','vendor.id','si.owner_id')
                ->leftJoin('users as customer', 'customer.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('communities as community', 'community.id','o.delivery_person_id')
                ->leftJoin('users as community_user', 'community_user.id','community.creater_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('vendor.name as vendor','vendor.phone as vendor_phone','si.shop_name','si.status as shop_active_status','si.shop_phone','si.shop_email','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','customer.name as customer','customer.phone as customer_phone','o.c_name as receiver_name','o.c_phone as receiver_phone','o.c_email as receiver_email','o.delivery_address','o.order_status as order_active_status','o.shipping_charge','o.payment_method','o.district as delivery_district','community_user.name as community_user_name','community_user.phone as community_user_phone','community.community_name','community.community_type','community.community_phone','community.community_email','community.village as community_village','community.union as community_union','community.upazila as community_upazila','community.district as community_district','community.division as community_division','community.country as community_country','Order_products.*')
                ->where('o.district','like',"%$user->district%")
                ->where('Order_products.id',$order_id)
                ->first();
            return view("back-end/admin/orders/shop/order-single-view",compact('order_product'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function adminOrderView($oID)
    {
        try {
            $order_id = decrypt($oID);
            $user = Auth::user();
            $order_product = Order_product::leftJoin('users as vendor','vendor.id','Order_products.vendor_id')
                ->leftJoin('shop_infos as si','vendor.id','si.owner_id')
                ->leftJoin('users as customer', 'customer.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('communities as community', 'community.id','o.delivery_person_id')
                ->leftJoin('users as community_user', 'community_user.id','community.creater_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('vendor.name as vendor','vendor.phone as vendor_phone','si.shop_name','si.status as shop_active_status','si.shop_phone','si.shop_email','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','customer.name as customer','customer.phone as customer_phone','o.c_name as receiver_name','o.c_phone as receiver_phone','o.c_email as receiver_email','o.delivery_address','o.order_status as order_active_status','o.shipping_charge','o.payment_method','o.district as delivery_district','community_user.name as community_user_name','community_user.phone as community_user_phone','community.community_name','community.community_type','community.community_phone','community.community_email','community.village as community_village','community.union as community_union','community.upazila as community_upazila','community.district as community_district','community.division as community_division','community.country as community_country','Order_products.*')
                ->where('o.district','like',"%$user->district%")
                ->where('Order_products.id',$order_id)
                ->first();
//            dd($order_product);
            return view("back-end/admin/orders/shop/order-single-view",compact('order_product'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function adminToAdminOrderReceived(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'orderId' => ['required','string'],
                ]);
                extract($request->post());
                $oID = decrypt($orderId);
                if ($o = Order_product::where('id',$oID)->where('order_status',10)->first())//3=vendor regional admin
                {
                    $nou = $o->number_of_updated++;
                    Order_product::where('id',$oID)->update([
                        'order_status'  =>  13,// 10=Customer Site Admin Hub
                        'updated_by'    =>  Auth::user()->id,
                        'number_of_updated' => $nou,
                        'updated_at'    =>  now(),
                    ]);
                    return back()->with('success','Data Update Successfully');
                }
            }
            return back()->with('error','Access denied!');
        }catch (\Throwable $exception)
        {
            back()->with('error',$exception->getMessage());
        }
    }

//Shop Order
    public function shopOrderList()
    {
        try {
            $user = Auth::user();
            $order_products = Order_product::leftJoin('users as u','u.id','Order_products.vendor_id')
                ->leftJoin('shop_infos as si','u.id','si.owner_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('u.name as vendor','si.shop_name','si.status as shop_active_status','si.shop_phone','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','Order_products.*')
                ->where('si.district','like',"%$user->district%")
                ->get();
            return view("back-end/admin/orders/shop/order-list",compact('order_products'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function shopOrderView($oID)
    {
        try {
            $order_id = decrypt($oID);
            $user = Auth::user();
            $order_product = Order_product::leftJoin('users as vendor','vendor.id','Order_products.vendor_id')
                ->leftJoin('shop_infos as si','vendor.id','si.owner_id')
                ->leftJoin('users as customer', 'customer.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('communities as community', 'community.id','o.delivery_person_id')
                ->leftJoin('users as community_user', 'community_user.id','community.creater_id')
                ->leftJoin('order_statuses as os','Order_products.order_status','os.status_value')
                ->select('vendor.name as vendor','vendor.phone as vendor_phone','si.shop_name','si.status as shop_active_status','si.shop_phone','si.shop_email','si.home as shop_home','si.village as shop_vill','si.union as shop_union','si.upazila as shop_upazila','o.invoice_id','p.p_name','p.p_image','os.status_name','os.status_value','os.title','os.badge','customer.name as customer','customer.phone as customer_phone','o.c_name as receiver_name','o.c_phone as receiver_phone','o.c_email as receiver_email','o.delivery_address','o.order_status as order_active_status','o.shipping_charge','o.payment_method','o.district as delivery_district','community_user.name as community_user_name','community_user.phone as community_user_phone','community.community_name','community.community_type','community.community_phone','community.community_email','community.village as community_village','community.union as community_union','community.upazila as community_upazila','community.district as community_district','community.division as community_division','community.country as community_country','Order_products.*')
                ->where('si.district','like',"%$user->district%")
                ->where('Order_products.id',$order_id)
                ->first();
//            dd($order_product);
            return view("back-end/admin/orders/shop/order-single-view",compact('order_product'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function adminOrderReceivedShop(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'orderId' => ['required','string'],
                ]);
                extract($request->post());
                $oID = decrypt($orderId);
                if ($o = Order_product::where('id',$oID)->where('order_status',9)->first())//9=vendor request to admin
                {
                    $nou = $o->number_of_updated++;
                    Order_product::where('id',$oID)->update([
                        'order_status'  =>  12,// 12=Vendor site community Hub
                        'updated_by'    =>  Auth::user()->id,
                        'number_of_updated' => $nou,
                        'updated_at'    =>  now(),
                    ]);
                    return back()->with('success','Data Update Successfully');
                }
            }
            return back()->with('error','Access denied!');
        }catch (\Throwable $exception)
        {
            back()->with('error',$exception->getMessage());
        }
    }
    public function shopOrderSendAdmin(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'orderId' => ['required','string'],
                ]);
                extract($request->post());
                $oID = decrypt($orderId);
                if ($o = Order_product::where('id',$oID)->where('order_status',3)->first())//3=vendor regional admin
                {
                    $nou = $o->number_of_updated++;
                    Order_product::where('id',$oID)->update([
                        'order_status'  =>  10,// 10=admin to admin request
                        'updated_by'    =>  Auth::user()->id,
                        'number_of_updated' => $nou,
                        'updated_at'    =>  now(),
                    ]);
                    return back()->with('success','Data Update Successfully');
                }
            }
            return back()->with('error','Access denied!');
        }catch (\Throwable $exception)
        {
            back()->with('error',$exception->getMessage());
        }
    }
    public function shopOrderReceivedAdmin(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'orderId' => ['required','string'],
                ]);
                extract($request->post());
                $oID = decrypt($orderId);
                if ($o = Order_product::where('id',$oID)->where('order_status',10)->first())//10=Vendor site admin to Customer site admin request
                {
                    $nou = $o->number_of_updated++;
                    Order_product::where('id',$oID)->update([
                        'order_status'  =>  13,// 13=customer regional admin
                        'updated_by'    =>  Auth::user()->id,
                        'number_of_updated' => $nou,
                        'updated_at'    =>  now(),
                    ]);
                    return back()->with('success','Data Update Successfully');
                }
            }
            return back()->with('error','Access denied!');
        }catch (\Throwable $exception)
        {
            back()->with('error',$exception->getMessage());
        }
    }
    public function communityToAdminOrderReceived(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'orderId' => ['required','string'],
                ]);
                extract($request->post());
                $oID = decrypt($orderId);
                if ($o = Order_product::where('id',$oID)->where('order_status',14)->first())//14=Vendor site community request to admin
                {
                    $nou = $o->number_of_updated++;
                    Order_product::where('id',$oID)->update([
                        'order_status'  =>  3,// 3=Handed over on vendor site logistic partner
                        'updated_by'    =>  Auth::user()->id,
                        'number_of_updated' => $nou,
                        'updated_at'    =>  now(),
                    ]);
                    return back()->with('success','Data Update Successfully');
                }
            }
            return back()->with('error','Access denied!');
        }catch (\Throwable $exception)
        {
            back()->with('error',$exception->getMessage());
        }
    }
    public function shopOrderSendRequestCommunity(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'orderId' => ['required','string'],
                ]);
                extract($request->post());
                $oID = decrypt($orderId);
                if ($o = Order_product::where('id',$oID)->where('order_status',3)->orWhere('order_status',13)->orWhere('order_status',12)->first())//4=Customer site admin
                {
                    $nou = $o->number_of_updated++;
                    Order_product::where('id',$oID)->update([
                        'order_status'  =>  4,// 4=Waiting for Delivery Community
                        'updated_by'    =>  Auth::user()->id,
                        'number_of_updated' => $nou,
                        'updated_at'    =>  now(),
                    ]);
                    return back()->with('success','Data Update Successfully');
                }
            }
            return back()->with('error','Access denied!');
        }catch (\Throwable $exception)
        {
            back()->with('error',$exception->getMessage());
        }
    }
}
