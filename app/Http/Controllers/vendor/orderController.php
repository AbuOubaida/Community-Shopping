<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\shop_info;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    public function __construct()
    {
        try {
            $this->middleware(function ($request,$next){
                $this->user_info = Auth::user();
                $shop_info = shop_info::where('owner_id',$this->user_info->id)->first();

                if ($shop_info)
                {
                    if ($shop_info->status != 1)
                    {
                        return redirect(route('my.shop'));
                    }
                    return $next($request);

                }
                else {
                    return redirect(route('create.shop'));
                }
            });
        }catch (\Throwable $exception)
        {
            return back();
        }

    }
    public function newOrder ()
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'New Order List'];
        $me = Auth::user();
        $orders = order::leftJoin('users as u','u.id','orders.customer_id')
            ->leftJoin('products as p','p.id','orders.products_id')
            ->select('u.name as customer_name','p.p_name as product','p.p_image as image','orders.*')
            ->where('orders.order_complete_status','0')->where('orders.vendor_id',$me->id)->get();
        return view('back-end.vendor.orders.order-list',compact('headerData','orders'));
    }

    public function viewOrder($orderID)
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'New Order View'];
        $me = Auth::user();
        $order = order::leftJoin('users as u','u.id','orders.customer_id')
            ->leftJoin('products as p','p.id','orders.products_id')
            ->select('u.name as customer_name','p.p_name as product','p.p_image as image','orders.*','p.p_price','p.offer_quantity','p.p_quantity','p.offer_percentage','p.offer_start_time','p.offer_end_time','p.p_details')
            ->where('orders.order_complete_status','0')->where('orders.vendor_id',$me->id)->where('orders.id',$orderID)->first();
//        dd($order);
        return view('back-end.vendor.orders.order-view',compact('headerData','order'));
    }
    public function delOrder ()
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'New Order List'];
        $me = Auth::user();
        $orders = order::leftJoin('users as u','u.id','orders.customer_id')
            ->leftJoin('products as p','p.id','orders.products_id')
            ->select('u.name as customer_name','p.p_name as product','p.p_image as image','orders.*')
            ->where('orders.order_complete_status','1')->where('orders.vendor_id',$me->id)->get();
        return view('back-end.vendor.orders.order-list',compact('headerData','orders'));
    }

    public function orderDelivery($oID)
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'New Order Delivery'];
        $order = order::where('id',$oID)->first();
        $deliveryPerson = User::leftJoin('role_user as ru','ru.user_id','users.id')->where('ru.role_id','4')->select('users.name as delivery_p_n','users.id as user_id')->get();
        return view('back-end.vendor.orders.delivery',compact('deliveryPerson','order','headerData'));
    }

    public function updateOrderDelivery (Request $request)
    {
        try {
            extract($request->post());
            order::where('id',$oid)->update([
                'delivery_person_id' => $del,
                'order_complete_status' => 1,
            ]);
            return redirect()->route('new.order.list')->with('success','Order Delivered Successfully');
        }catch (\Throwable $exception)
        {
            return back();
        }
    }
}
