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
        $headerData = ['app'=>'Online Food Delivery System','role'=>'User','title'=>'My Order List'];
        $me = Auth::user();
        $orders = order::leftJoin('users as u','u.id','orders.customer_id')
            ->select(DB::raw("(select count(id) from order_products as op where op.order_id = orders.order_id) as nop"),'u.name as customer_name','orders.*')->where('orders.customer_id',$me->id)->get();
        return view('back-end.user.orders.order-list',compact('headerData','orders'));
    }

    public function orderSingle($orderID)
    {
//        dd(route("my.order.list"));
        $headerData = ['app'=>'Online Food Delivery System','role'=>'User','title'=>'My Order view'];
        $cID = Auth::user()->id;
        $order = order::where('order_id',$orderID)->where('customer_id',$cID)->first();
        $order_products = Order_product::leftJoin("products as p",'p.id','order_products.product_id')->where('order_products.order_id',$orderID)->where('order_products.customer_id',$cID)->select('p.p_name as product_name','order_products.*')->get();
        return view("back-end/user/orders/order-single-view",compact('order','order_products','headerData'));

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
                        echo route("my.order.list");
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
