<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function myOrder()
    {
        $headerData = ['app'=>'Online Food Delivery System','role'=>'User','title'=>'My Order List'];
        $me = Auth::user();
        $orders = order::leftJoin('users as u','u.id','orders.customer_id')
            ->leftJoin('products as p','p.id','orders.products_id')
            ->select('u.name as customer_name','p.p_name as product','p.p_image as image','orders.*')
            ->where('orders.customer_id',$me->id)->get();
        return view('back-end.user.orders.order-list',compact('headerData','orders'));
    }
}
