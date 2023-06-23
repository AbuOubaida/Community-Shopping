<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\Order_product;
use App\Models\shop_info;
use App\Models\User;
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
            Order_product::where('order_status',1)->where('id',$oID)->where('vendor_id',$user->id)->update([
                'order_status' => 2,
            ]);
            return back()->with('success','Order accept successfully');
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
//            dd($order_product);
            return view("back-end/vendor/orders/order-single-view",compact('order_product','headerData'));
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
