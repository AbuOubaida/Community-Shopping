<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\Order_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function myOrder()
    {
        try {
            $headerData = ['app'=>str_replace("_"," ",config("app.name")),'role'=>'User','title'=>'My Order List'];
            $me = Auth::user();
            $orders = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('products as p','p.id','order_products.product_id')
                ->leftJoin('order_statuses as os','order_products.order_status','os.status_value')
                ->select('p.id as p_id','p.p_name','p.p_image','o.invoice_id','order_products.*','os.status_name','os.status_value','os.title','os.badge')->where('o.customer_id',$me->id)->orderBy('id','desc')->get();
            return view('back-end.user.orders.order-list',compact('headerData','orders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function orderSingle($orderID)
    {
        try {
            $headerData = ['app'=>str_replace("_"," ",config("app.name")) ,'role'=>'User','title'=>'My Order view'];
            $oID = decrypt($orderID);
            $me = Auth::user();
            $order = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('products as p','p.id','order_products.product_id')
                ->leftJoin('shop_infos as shop','p.vendor_id','shop.owner_id')
                ->leftJoin('communities as c','c.id','o.delivery_person_id')
                ->leftJoin('order_statuses as os','order_products.order_status','os.status_value')
                ->select('shop.id as shop_id','shop.shop_name','p.id as p_id','p.p_name','p.p_image','o.invoice_id','os.status_name','o.c_name','o.c_phone','o.c_email','o.delivery_address','o.shipping_charge','o.order_status as status','o.payment_method','os.status_value','os.title','os.badge','c.community_name','c.community_phone','c.community_email','c.community_type','c.home as community_home','c.village as community_village','c.word as community_word','c.union as community_union','c.upazila as community_upazila','c.district as community_district','c.country as community_country','order_products.*')->where('o.customer_id',$me->id)->where('order_products.id',$oID)->first();
            return view("back-end/user/orders/order-single-view-product-wise",compact('order','headerData'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function userAcceptOrder(Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                $request->validate([
                    'ref'   =>  ['required','string']
                ]);
                extract($request->post());
                $oID = decrypt($ref);
                $me = Auth::user();
                $order = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')->where('order_products.order_status',6)->where('o.customer_id',$me->id)->where('order_products.id',$oID)->select('o.invoice_id','order_products.*')->first();
//                dd($order);
                if ($order)
                {
                    $nou = $order->number_of_updated + 1;
                    Order_product::where('id',$oID)->update([
                        'order_status'  =>  7, //7=Received
                        'number_of_updated'=>  $nou,
                        'updated_by'     => $me->id,
                    ]);
                    return back()->with('success','Data update successfully');
                }
                return back()->with('error','Order Not Found!');
            }
            return back()->with('error','Access Denied!');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function cancelProductOrder(Request $request)
    {
        try {
            if ($request->isMethod('post'))
            {
                $id = decrypt($request->value);
                $user = Auth::user();
                if (Order_product::where('customer_id',$user->id)->where('id',$id)->where("order_status",1)->first())
                {
                    try {
                        Order_product::where('customer_id',$user->id)->where('id',$id)->update([
                            'order_status'  => 0,
                            'updated_by'    =>  $user->id,
                            'updated_at'    =>  now(),
                        ]);
                        echo json_encode(array(
                            'success' => array(
                                'msg' => "Order cancel successfully!",
                                'code' => 201,
                            )
                        ));
                    }catch (\Throwable $exception)
                    {
                        echo json_encode(array(
                            'error' => array(
                                'msg' => $exception->getMessage(),
                                'code' => $exception->getCode(),
                            )
                        ));
                    }

                }else{
                    echo json_encode(array(
                        'error' => array(
                            'msg' => "Not Found!",
                            'code' => 404,
                        )
                    ));
                }
            }else{
                echo json_encode(array(
                    'error' => array(
                        'msg' => "Bad Request ",
                        'code' => 400,
                    )
                ));
            }
        }catch (\Throwable $exception)
        {
            echo json_encode(array(
                'error' => array(
                    'msg' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                )
            ));
        }
    }
    public function cancelOrder(Request $request)
    {
        try {
            if ($request->isMethod('post'))
            {
                $oderID = decrypt($request->value);
                $user = Auth::user();
                if (order::where("order_id",$oderID)->where("customer_id",$user->id)->where("order_complete_status",0)->first())
                {
                    try {
                        order::where("order_id",$oderID)->where("customer_id",$user->id)->where("order_complete_status",0)->update([
                            'order_status' => 0,
                        ]);
                        $products = Order_product::where('customer_id',$user->id)->where('order_id',$oderID)->where("order_status",1)->get();
                        if (count($products))
                        {
                            foreach ($products as $p)
                            {
                                Order_product::where('customer_id',$user->id)->where('id',$p->id)->where('order_id',$oderID)->update([
                                    'order_status'  => 0,
                                    'updated_by'    =>  $user->id,
                                    'updated_at'    =>  now(),
                                ]);
                            }
                        }
                        if (Auth::user()->hasRole('user'))
                        {
                            echo route("my.order.list");
                        }elseif (Auth::user()->hasRole('community'))
                        {
                            echo route("community.my.order");
                        }elseif (Auth::user()->hasRole('vendor'))
                        {
                            echo route("vendor.my.order");
                        }elseif (Auth::user()->hasRole('admin'))
                        {
                            echo route("admin.my.order");
                        }elseif (Auth::user()->hasRole('superadmin'))
                        {
                            echo route("super.my.order");
                        }else {
                            echo route('login');
                        }

                    }catch (\Throwable $exception)
                    {
                        echo json_encode(array(
                            'error' => array(
                                'msg' => $exception->getMessage(),
                                'code' => $exception->getCode(),
                            )
                        ));
                    }
                }
            }else{
                echo json_encode(array(
                    'error' => array(
                        'msg' => "Bad Request ",
                        'code' => 400,
                    )
                ));
            }
        }catch (\Throwable $exception)
        {
            echo json_encode(array(
                'error' => array(
                    'msg' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                )
            ));
        }
    }
}
