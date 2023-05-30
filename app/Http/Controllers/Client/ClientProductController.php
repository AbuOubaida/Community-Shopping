<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\communities;
use App\Models\order;
use App\Models\product;
use App\Models\shipping_charges;
use App\Models\shop_info;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use TheSeer\Tokenizer\Exception;
use function PHPUnit\Framework\isEmpty;

class ClientProductController extends Controller
{

    public function index($productID)
    {
        try {
            $productID = decrypt($productID);
            $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'Single Product View'];//page title[optional]
            $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>'Shop','parentRoute'=>'client.product.list','this'=>'Single Product'];
            $product = Product::leftJoin('users as v','v.id','products.vendor_id')// v as for product vendor info from user
            ->leftJoin('users as c','c.id','products.creater_id')// c as product creater info from user
            ->leftJoin('users as up','up.id','products.updater_id')// up as product updater info from user
            ->leftJoin('categories as cate','cate.id','products.category_id')//cate as categories table
            ->leftJoin('shop_infos as shop','shop.owner_id','v.id')//shop as shop_info table
            ->select('v.name as vendor_name','shop.shop_name as shop_name','shop.shop_profile_image as v_image','shop.profile_image_path as v_img_path','c.name as creater_name','up.name as updater_name','cate.c_name as category_name','products.*')->where("products.p_status", 1)->where('products.id',$productID)->first();
            return view('client-site.view-single-product',compact('headerData','product','pageInfo')); // view from resources folder.
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getCode());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show()//shop page
    {
        try {
            $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'Single Product View'];
            $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>null,'parentRoute'=>null,'this'=>'Shop'];

            $productLists = Product::leftJoin('users as v','v.id','products.vendor_id')// v as for product vendor info from user
            ->leftJoin('users as c','c.id','products.creater_id')// c as product creater info from user
            ->leftJoin('users as up','up.id','products.updater_id')// up as product updater info from user
            ->leftJoin('categories as cate','cate.id','products.category_id')//cate as categories table
            ->leftJoin('shop_infos as shop','shop.owner_id','v.id')//shop as shop_info table
            ->select('v.name as vendor_name','shop.shop_name as shop_name','shop.shop_profile_image as v_image','shop.profile_image_path as v_img_path','c.name as creater_name','up.name as updater_name','cate.c_name as category_name','products.*')
                ->where("products.p_status", 1)->where('p_image','!=',null)->orderBy("id", "DESC")->get();

            return view('client-site.product-list',compact('headerData','pageInfo','productLists'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getCode());
        }

    }

    public function showByVendorProduct($vendorId): View|Factory|string|Application|RedirectResponse
    {
        try {
            $vendor_id = decrypt($vendorId);
            $vendor = User::leftJoin('shop_infos as shop','shop.owner_id','users.id')->where('users.status',1)->where('users.id',$vendor_id)->where('shop.status',1)->where('shop.owner_id',$vendor_id)->select('users.id as vendor_id','shop.shop_name','users.name as vendor_name')->first();
            if (!($vendor))
            {
                return back();
            }
            $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'Vendor Product List'];
            $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>'Shop','parentRoute'=>'client.product.list','this'=> $vendor->shop_name ?? $vendor->vendor_name];

            $productLists = Product::leftJoin('users as v','v.id','products.vendor_id')// v as for product vendor info from user
            ->leftJoin('users as c','c.id','products.creater_id')// c as product creater info from user
            ->leftJoin('users as up','up.id','products.updater_id')// up as product updater info from user
            ->leftJoin('categories as cate','cate.id','products.category_id')//cate as categories table
            ->leftJoin('shop_infos as shop','shop.owner_id','v.id')//shop as shop_info table
            ->select('v.name as vendor_name','shop.shop_name as shop_name','shop.shop_profile_image as v_image','shop.profile_image_path as v_img_path','c.name as creater_name','up.name as updater_name','cate.c_name as category_name','products.*')
            ->where("products.p_status", 1)->where("products.vendor_id", $vendor_id)->where('p_image','!=',null)->orderBy("id", "DESC")->get();
            return view('client-site.vendor-product-list',compact('headerData','pageInfo','productLists'));
        }catch (\Throwable $exception)
        {
            return $exception->getMessage();
        }
    }

    public function addToCart(Request $request)
    {
        extract($request->post());
        $product_id = decrypt($id);
        try {
            $product = Product::leftJoin('users as v','v.id','products.vendor_id')// v as for product vendor info from user
            ->leftJoin('users as c','c.id','products.creater_id')// c as product creater info from user
            ->leftJoin('users as up','up.id','products.updater_id')// up as product updater info from user
            ->leftJoin('categories as cate','cate.id','products.category_id')//cate as categories table
            ->select('v.name as vendor_name','c.name as creater_name','up.name as updater_name','cate.c_name as category_name','products.*')->where("products.p_status", 1)->where('products.id',$product_id)->first();

            $cart = session()->get('cart');
            if (!$cart)
            {
                $cart[$product_id] = [
                    'p_id' => $product->id,
                    'name' => $product->p_name,
                    'quantity' => 1,
                    'price' => $product->p_price,
                    'photo' => $product->p_image,
                    'category' => $product->category_name,
                    'vendor' => $product->vendor_name,
                ];
                session()->put('cart',$cart);

            }
            else if (isset($cart[$product_id]))
            {
                $cart[$product_id]['quantity']++;
                session()->put('cart',$cart);
            }
            else{
                $cart[$product_id] = [
                    'p_id' => $product->id,
                    'name' => $product->p_name,
                    'quantity' => 1,
                    'price' => $product->p_price,
                    'photo' => $product->p_image,
                    'category' => $product->category_name,
                    'vendor' => $product->vendor_name,
                ];
            }
            session()->put('cart',$cart);
            if(session('cart')) echo count(session('cart')); else echo 0;

        }catch (\Throwable $exception)
        {
            return back();
        }


    }

    public function viewCart()
    {
        try {
            $countries = DB::table('countries')->distinct()->get();
            $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'Shopping Cart'];
            $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>'Shop','parentRoute'=>'client.product.list','this'=>'Shopping Cart'];
            $comm = null;
            if ($user = Auth::user())
            {
                $comm = $this->communityGet($user, $comm);
                if (strtolower($user->division) == 'dhaka' )
                {
                    $shippingCharge = shipping_charges::where('location_name',"Inside of Dhaka")->first();
                }else {
                    $shippingCharge = shipping_charges::where('location_name',"Outside of Dhaka")->first();
                }
            }else{
                $shippingCharge = shipping_charges::where('location_name',"Unknown")->first();
            }
//        session()->put('url',\Illuminate\Support\Facades\Route::current()->getName());
            return view('client-site.shop-cart',compact('headerData','pageInfo','shippingCharge','countries','comm'));
        }catch (\Throwable $exception)
        {
            back();
        }


    }
    private function communityGet(User $user,$comm)
    {
        $comm = communities::where('village',$user->village)->where('status',1)->get();
        if (count($comm) == 0)
        {
            $comm = communities::where('word',$user->word)->where('status',1)->get(4);
            if (count($comm) == 0)
            {
                $comm = communities::where('union',$user->union)->where('status',1)->get(4);
                if (count($comm) == 0)
                {
                    $comm = communities::where('upazila',$user->upazila)->where('status',1)->get(4);
                    if (count($comm) == 0)
                    {
                        $comm = communities::where('district',$user->district)->where('status',1)->get(4);
                        if (count($comm) == 0)
                        {
                            $comm = communities::where('division',$user->division)->where('status',1)->get(4);
                            if (count($comm) == 0)
                            {
                                $comm = communities::where('country',$user->country)->where('status',1)->get(4);
                                if (count($comm) == 0)
                                {
                                    $comm = communities::where('status',1)->where(function ($query) use ($user){
                                        $query->where('village','like',"%$user->village%");
                                        $query->orWhere('word','like',"%$user->word%");
                                        $query->orWhere('union','like',"%$user->union%");
                                        $query->orWhere('upazila','like',"%$user->upazila%");
                                        $query->orWhere('district','like',"%$user->district%");
                                        $query->orWhere('division','like',"%$user->division%");
                                        $query->orWhere('country','like',"%$user->country%");
                                    })->get(4);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $comm;
    }

    public function changeAddress(Request $request)
    {
        if ($request->ajax())
        {
            try {
                extract($request->post());
                if ($value)
                {
                    if (strtolower($value) == 'dhaka' )
                    {
                        $shippingCharge = shipping_charges::where('location_name',"Inside of Dhaka")->first();
                    }else {
                        $shippingCharge = shipping_charges::where('location_name',"Outside of Dhaka")->first();
                    }
                }else{
                    $shippingCharge = shipping_charges::where('location_name',"Unknown")->first();
                }
                $total = 0;
                if(\session('cart'))
                {
                    foreach(session('cart') as $id => $details)
                    {
                        $total += $details['price'] * $details['quantity'];
                    }
                }
                return view('layouts/front-end/_card_total',compact('total','shippingCharge'));

            }catch (\Throwable $exception)
            {
                return $exception->getMessage();
            }
        }

    }

    public function updateCart(Request $request)
    {
        extract($request->post());
        if($id and $quantity and $op)
        {
            $qnt = $quantity;
            if ($op == 'inc')
            {
                if ($qnt < 5) $qnt++;
            }
            else if ($op == 'dec'){
               if ($qnt > 1) $qnt-- ;
            }
            $cart = session()->get('cart');


            $cart[$id]["quantity"] = $qnt;

            session()->put('cart', $cart);

            //session()->flash('success', 'Cart updated successfully');
            echo $qnt;
        }
    }

    public function deleteCart(Request $request)
    {
        if($request->id) {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }

    public function checkOut(Request $request)
    {
        if ($request->isMethod('post'))
        {

            $request->validate([
                'customer_name' =>  ['required','string',$this->htmlValidator()],
                'email' =>  ['required','email',$this->htmlValidator()],
                'phone' =>  ['required','digits:11',$this->htmlValidator()],
                'village' => ['string','sometimes','nullable', 'max:255',$this->htmlValidator()],
                'word_no' => ['string','sometimes','nullable', 'max:255',$this->htmlValidator()],
                'union' => ['string','sometimes','nullable', 'max:255',$this->htmlValidator()],
                'upazila' => ['string','required', 'max:255',$this->htmlValidator()],
                'district' => ['string','required', 'max:255',$this->htmlValidator()],
                'zip_code' => ['string','sometimes','nullable', 'max:255',$this->htmlValidator()],
                'division' => ['string','required', 'max:255',$this->htmlValidator()],
                'country' => ['string','required', 'max:255',$this->htmlValidator()],
                'road' => ['string','sometimes','nullable', 'max:255',$this->htmlValidator()],
                'house' => ['string','sometimes','nullable', 'max:255',$this->htmlValidator()],
                'extra' => ['string','sometimes','nullable', 'max:255',$this->htmlValidator()],
                'payment' => ['numeric','required', 'max:2',$this->htmlValidator()],
            ]);
            try {
                $village = null; $word_no = null; $union = null; $upazila = null; $zip_code = null; $district = null; $division = null; $country = null; $road = null; $house = null; $extra = null;
                extract($request->post());
                $address = "House: $house, Road: $road, Village: $village, Word: $word_no, Union: $union, Upazila: $upazila, Zip Code: $zip_code, District: $district, Division: $division, Country: $country, Extra Info: $extra";
                $cID = Auth::user()->id;
                $orderID = rand(0, 99999);
                $cart = session()->get('cart');
                foreach(session('cart') as $id => $details)
                {
                    $product = product::where('id',$details['p_id'])->first();
                    order::create([
                        'order_id' => $orderID,
                        'customer_id' => $cID,
                        'products_id' => $product['id'],
                        'vendor_id' => $product['vendor_id'],
                        'delivery_address' => $address,
                        'c_phone' => $phone,
                        'c_email' => $email,
                        'order_status' => 1,
                        'order_quantity' => $details['quantity'],
                        'price' => ($details['quantity'] * $details['price']),
                        'payment_method' => $payment,
                    ]);
                }
                session()->forget(['cart']);
                return redirect()->route('my.order.list')->with('success','Order successfully!');
            }catch (\Throwable $exception)
            {
                return back()->withInput()->with('error',$exception->getMessage());
            }

        }
        else{
            return redirect()->route('view.cart');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return Response
     */
    public function destroy(product $product)
    {
        //
    }
}
