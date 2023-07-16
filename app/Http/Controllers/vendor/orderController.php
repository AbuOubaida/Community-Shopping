<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\communities;
use App\Models\community_order_from_shop;
use App\Models\order;
use App\Models\Order_product;
use App\Models\shop_info;
use App\Models\User;
use App\Models\vendor_community_list;
use Barryvdh\DomPDF\Facade\Pdf;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function primaryOrder ()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'New Order List'];
            $me = Auth::user();
            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')
                ->where('Order_products.order_status',1)->where('order_products.vendor_id',$me->id)->get();
            return view('back-end.vendor.orders.primary.order-list',compact('headerData','primaryOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function acceptedOrder (Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                return $this->acceptedOrderSubmit($request);
            }
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'New Order List'];
            $me = Auth::user();
            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')->where('order_products.vendor_id',$me->id)->where(function ($query){
                    $query->where('Order_products.order_status',2);
                    $query->orWhere('Order_products.order_status',9);
                    $query->orWhere('Order_products.order_status',11);
                })->get();
            return view('back-end.vendor.orders.accepted.order-list',compact('headerData','primaryOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    private function acceptedOrderSubmit(Request $request)
    {
        try {
            $request->validate([
                'product_id' => ['required', 'string'],
            ]);
            extract($request->post());
            $oID = decrypt($product_id); //oID = order_product table primary key (id)
            $user = Auth::user();
            $userOrder = Order_product::where('order_status',1)->where('id',$oID)->where('vendor_id',$user->id)->first();
            Order_product::where('order_status',1)->where('id',$oID)->where('vendor_id',$user->id)->update([
                'order_status' => 2,
                'updated_by' =>  $user->id,
                'number_of_updated'  =>  ($userOrder->number_of_updated + 1),
            ]);
            return back()->with('success','Order accept successfully');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function sendingAdminOrder (Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                return $this->acceptedOrderSubmit($request);
            }
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'New Order List'];
            $me = Auth::user();
            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')->where('order_products.vendor_id',$me->id)->where(function ($query){
                    $query->where('Order_products.order_status',9);
                    $query->orWhere('Order_products.order_status',10);
                })->get();
            return view('back-end.vendor.orders.sending.order-list',compact('headerData','primaryOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function submitAdmin(Request $request)
    {
        try {
            $request->validate([
                'order_id' => ['required', 'string'],
            ]);
            extract($request->post());
//            dd($order_id);
            $oID = decrypt($order_id); //oID = order_product table primary key (id)
            $user = Auth::user();
            Order_product::where('order_status',2)->where('id',$oID)->where('vendor_id',$user->id)->update([
                'order_status' => 9,
            ]);
            return back()->with('success','Order accept successfully');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function sendingCommunityOrder (Request $request)
    {
        try {
            if ($request->isMethod('put'))
            {
                return $this->acceptedOrderSubmit($request);
            }
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'New Order List'];
            $me = Auth::user();
            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')->where('order_products.vendor_id',$me->id)->where(function ($query){
                    $query->where('Order_products.order_status',11);
                    $query->orWhere('Order_products.order_status',12);
                })->get();
            return view('back-end.vendor.orders.sending.order-list',compact('headerData','primaryOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function submitOrderCommunity(Request $request)
    {
        try {
            $request->validate([
                'order_id' => ['required','string'],
                'community' => ['required','string'],
            ]);
            extract($request->post());
            $oID = decrypt($order_id);
            $cID = decrypt($community);
            $user = Auth::user();
            $userOrder = Order_product::where('vendor_id',$user->id)->where('id',$oID)->first();
            if (!($userOrder))
            {
                return back()->with('error','Access denied! Invalid order id');
            }
            $userCommunity = vendor_community_list::where('vendor_id',$user->id)->where('id',$cID)->where('status',1)->first();
            if (!($userCommunity))
            {
                return back()->with('error','Access denied! Invalid community id');
            }
            $community = communities::where('id',$userCommunity->community_id)->where('status',1)->first();
            $shop = shop_info::where('owner_id',$user->id)->where('status',1)->first();
            if (community_order_from_shop::where('order_id',$userOrder->id)->where('status',1)->first())
            {
                return back()->with('error','Data already exist in database!');
            }
            community_order_from_shop::create([
                'order_id'      =>  $userOrder->id,
                'shop_id'       =>  $shop->id,
                'community_id'  =>  $userCommunity->id,
                'status'        =>  1,//1= Shop request to community
            ]);
            Order_product::where('vendor_id',$user->id)->where('id',$oID)->where('order_status',2)->update([
                'order_status'    =>  11,// Vendor request to community
                'updated_by' =>  $user->id,
                'number_of_updated'  =>  ($userOrder->number_of_updated + 1),
            ]);
            return back()->with('success', "Request send successfully");
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function viewOrder($orderID)
    {
        try {
            $headerData = ['app'=>str_replace("_"," ",config("app.name")) ,'role'=>'User','title'=>'My Order view'];
            $cID = Auth::user()->id;
            $oID = decrypt($orderID); //oID = order_product table primary key (id)
            $order_product = Order_product::leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->where('order_products.id',$oID)->where('order_products.vendor_id',$cID)->select('p.p_name as product_name','order_products.*','o.invoice_id','u.name as customer_name')->first();
            $vendorCommunities = vendor_community_list::leftJoin('communities as c','c.id','vendor_community_lists.community_id')->where('vendor_community_lists.vendor_id',$cID)->where('vendor_community_lists.status',1)->select('c.community_name as community','c.community_type','c.village','c.home','c.word','c.union','c.upazila','c.district','c.division','c.country','vendor_community_lists.*')->get();
            return view("back-end/vendor/orders/order-single-view",compact('order_product','headerData','vendorCommunities'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function InvoicePDF($orderID)
    {
        try {
            $cID = Auth::user()->id;
            $oID = decrypt($orderID); //oID = order_product table primary key (id)
            $order_product = Order_product::leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->where('order_products.id',$oID)->where('order_products.vendor_id',$cID)->select('p.p_name as product_name','order_products.*','o.invoice_id','u.name as customer_name')->first();
//            dd($order_product->product_name);
//        return view("back-end/vendor/invoice_print_product_wise",compact("order_product"));
            $pdf = PDF::loadView('back-end/vendor/invoice_print_product_wise',compact('order_product'));
            $output = $pdf->output();

            return new Response($output, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'inline',
                'filename'=>"$oID'_invoice.pdf'"]);
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function viewInvoice($invoiceID)
    {
        try {
            $invoice = decrypt($invoiceID);
            $user = Auth::user();
            $order = order::leftJoin('order_products as op','op.order_id','orders.order_id')->where('orders.invoice_id',$invoice)->where('op.vendor_id',$user->id)->first();
            $order_products = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('products as p','p.id','order_products.product_id')
                ->where('o.invoice_id',$invoice)->where('order_products.vendor_id',$user->id)->select('p.p_name as product_name','order_products.*')->get();
            return view("back-end/vendor/orders/order-invoice-view",compact('order','order_products'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function viewInvoicePdf($invoiceID)
    {
        try {
            $invoice = decrypt($invoiceID);
            $user = Auth::user();
            $order = order::leftJoin('order_products as op','op.order_id','orders.order_id')->where('orders.invoice_id',$invoice)->where('op.vendor_id',$user->id)->first();
            $order_products = Order_product::leftJoin('orders as o','o.order_id','order_products.order_id')
                ->leftJoin('products as p','p.id','order_products.product_id')
                ->where('o.invoice_id',$invoice)->where('order_products.vendor_id',$user->id)->select('p.p_name as product_name','order_products.*')->get();
//            return view('back-end/vendor/invoice_print_invoice_wise',compact('order_products','order'));

            $pdf = PDF::loadView('back-end/vendor/invoice_print_invoice_wise',compact('order_products','order'));
            $output = $pdf->output();

            return new Response($output, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'inline',
                'filename'=>"$invoice'_invoice.pdf'"]);
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function canceledOrder()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'New Order List'];
            $me = Auth::user();
            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')
                ->where('Order_products.order_status',0)->where('order_products.vendor_id',$me->id)->get();
            return view('back-end.vendor.orders.canceled.order-list',compact('headerData','primaryOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function completeOrderList()
    {
        try {
            $headerData = ['app'=>str_replace('_',' ',config('app.name')),'role'=>Auth::user()->roles()->first()->display_name,'title'=>'New Order List'];
            $me = Auth::user();
            $primaryOrders = Order_product::leftJoin('users as u','u.id','Order_products.customer_id')
                ->leftJoin("products as p",'p.id','order_products.product_id')
                ->leftJoin('orders as o','o.order_id','order_products.order_id')
                ->select('u.name as customer_name','o.invoice_id','p.p_name','p.p_image','p.p_quantity','Order_products.*')
                ->where('Order_products.order_status',3)->where('order_products.vendor_id',$me->id)->get();
            return view('back-end.vendor.orders.completed.order-list',compact('headerData','primaryOrders'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'product_id' => ['required', 'string'],
            ]);
            extract($request->post());
            $oID = decrypt($product_id); //oID = order_product table primary key (id)
            $user = Auth::user();
            Order_product::where('order_status',1)->where('id',$oID)->where('vendor_id',$user->id)->update([
                'order_status' => 0,
            ]);
            return back()->with('success','Order cancel successfully');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
}
