<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\Product;
use App\Models\shop_info;
use App\Models\user;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class VendorProductController extends Controller
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
    private $productImage = "assets/back-end/vendor/product/";
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
    public function create(Request $request)
    {
        $user = Auth::user();
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'Add Product'];
        if ($request->isMethod('post'))
        {
            return $this->store($request);
        }else{
            $categories = category::where('status',1)->where('vendor_id',$user->id)->get();
            return view('back-end.vendor.products.add-new',compact('headerData','categories'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_slider = 0;
        $img_name = null;
//        dd($request->file('p_image')->getClientOriginalExtension());
//        data validation
        $request->validate([
            'pname' => ['required', 'string', 'max:255'],
            'price' => ['required','numeric'],
            'p_quantity' => ['required','numeric'],
            'p_details' => ['nullable','sometimes','string'],
            'p_category' => ['required','numeric'],// category ID
            'p_status' => ['required','numeric'],
            'o_status' => ['required','numeric'],// Product offer status
            'p_image' => ['mimes:jpeg,jpg,png,gif|sometimes|nullable|max:10000'],// Product Image maximum size 10MB
            'is_slider' => ['nullable','sometimes'],// Product Image if show on slider
            'offer_percentage' => ['nullable','sometimes','numeric'],
            'offer_quantity' => ['nullable','sometimes','numeric'],
            'offer_start_time' => ['nullable','sometimes'],
            'offer_end_time' => ['nullable','sometimes'],
        ]);
        try {
            extract($request->post()); // make html name attr. to php variable
            // If product has image then
            if ($request->hasFile('p_image'))
            {
                extract($request->file());
                if (@$p_image)
                {
                    try {
                        $ext = $p_image->getClientOriginalExtension();
                        $img_name = str_replace(' ','_',$pname).'_'.rand(111,99999).'_'.$p_image->getClientOriginalName();
                        $imageUploadPath = $this->productImage.$img_name;

                        Image::make($p_image)->save($imageUploadPath);
                    }catch (\Throwable $exception)
                    {
                        return back()->with('error',$exception->getMessage())->withInput();
                    }
                }
            }//Image end

            // Duplicate product check start
            if (Product::where('p_name',$pname)->where('p_price',$price)->where('category_id',$p_category)->first() != null)
            {
                return back()->with('warning','Product already exist in database')->withInput();
            }// Duplicate product check end

            if ($p_status >1 || $p_status < 0)
            {
                return back()->with('error','Invalid product status')->withInput();
            }

            if (isset($o_status))
            {
                if ($offer_quantity > $p_quantity)
                {
                    return back()->with('error','Offer quantity are not gather then product quantity')->withInput();
                }
            }
            $user = Auth::user();// store login user data
//            Insert data here [Insert into Products ('p_status') values($p_status)]
            Product::create([
                'p_status'  =>  $p_status,
                'offer_status' => $o_status,
                'vendor_id' => $user->id,
                'creater_id' => $user->id,
                'updater_id' => $user->id,
                'category_id' => $p_category,
                'p_name' => $pname,
                'p_price' => $price,
                'p_details' => $p_details,
                'p_quantity' => $p_quantity,
                'p_image' => $img_name,
                'p_slider_image' => $is_slider,
                'offer_percentage' => $offer_percentage,
                'offer_quantity' => $offer_percentage,
                'offer_start_time' => $offer_start_time,
                'offer_end_time' => $offer_end_time,
            ]);
            return back()->with('success','Data save successfully');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'Product list'];
        $products = Product::leftJoin('users as v','v.id','products.vendor_id')// v as for product vendor info from user
            ->leftJoin('users as c','c.id','products.creater_id')// c as product creater info from user
            ->leftJoin('users as up','up.id','products.updater_id')// up as product updater info from user
            ->leftJoin('categories as cate','cate.id','products.category_id')//cate as categories table
            ->select('v.name as vendor_name','c.name as creater_name','up.name as updater_name','cate.c_name as category_name','products.*')
            ->where("products.vendor_id", $user->id)->get();

//        dd($products);
        return \view('back-end.vendor.products.show-list',compact('headerData','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$productID)
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'Add Product'];
        if ($request->isMethod('post'))
        {
            return $this->update($request);
        }
        else{
            try {
                $user = Auth::user();
                $categories = category::where('status',1)->get();
                $product = Product::where('id',$productID)->where('vendor_id',$user->id)->first();

                return \view('back-end.vendor.products.edit',compact('categories','product','headerData'));
            }catch (\Throwable $exception)
            {
                return back()->with('error',$exception->getMessage());
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $is_slider = 0;
        $request->validate([
            'product_id' => ['required', 'numeric'],
            'pname' => ['required', 'string', 'max:255'],
            'price' => ['required','numeric'],
            'p_quantity' => ['required','numeric'],
            'p_details' => ['nullable','sometimes','string'],
            'p_category' => ['required','numeric'],// category ID
            'p_status' => ['required','numeric'],
            'o_status' => ['required','numeric'],// Product offer status
            'p_image' => ['mimes:jpeg,jpg,png,gif|sometimes|nullable|max:10000'],// Product Image maximum size 10MB
            'is_slider' => ['nullable','sometimes'],// Product Image if show on slider
            'offer_percentage' => ['nullable','sometimes','numeric'],
            'offer_quantity' => ['nullable','sometimes','numeric'],
            'offer_start_time' => ['nullable','sometimes'],
            'offer_end_time' => ['nullable','sometimes'],
        ]);
        try {
            extract($request->post());
            $user = Auth::user();
            $product = Product::where('id',$product_id)->where('vendor_id',$user->id)->first();
            if ($product == null)
            {
                return back()->with('error','Unauthorized Error!')->withInput();
            }
            $img_name = $product->p_image;
            if ($request->hasFile('p_image'))
            {
                extract($request->file());

                if (@$p_image)
                {
                    try {
                        $ext = $p_image->getClientOriginalExtension();
                        $img_name = str_replace(' ','_',$pname).'_'.rand(111,99999).'_'.$p_image->getClientOriginalName();
                        $imageUploadPath = $this->productImage.$img_name;
                        if ($product->p_image && file_exists($name = $this->productImage.$product->p_image))// old file delete if exist
                        {
                            unlink(public_path($name));
                        }
                        Image::make($p_image)->save($imageUploadPath);
                    }catch (\Throwable $exception)
                    {
                        return back()->with('error',$exception->getMessage())->withInput();
                    }
                }
            }
            if (Product::where('id','!=',$product_id)->where('category_id',$p_category)->where('p_name',$pname)->where('p_price',$price)->first() != null)
            {
                return back()->with('warning','Product already exist in database')->withInput();
            }
            if ($p_status >1 || $p_status < 0)
            {
                return back()->with('error','Invalid product status')->withInput();
            }
            if (isset($o_status))
            {
                if ($offer_quantity > $p_quantity)
                {
                    return back()->with('error','Offer quantity are not gather then product quantity')->withInput();
                }
            }
            Product::where('id',$product_id)->where("vendor_id",$user->id)->update([
                'p_status'  =>  $p_status,
                'offer_status' => $o_status,
                'updater_id' => $user->id,
                'category_id' => $p_category,
                'p_name' => $pname,
                'p_price' => $price,
                'p_details' => $p_details,
                'p_quantity' => $p_quantity,
                'p_image' => $img_name,
                'p_slider_image' => $is_slider,
                'offer_percentage' => $offer_percentage,
                'offer_quantity' => $offer_quantity,
                'offer_start_time' => $offer_start_time,
                'offer_end_time' => $offer_end_time,
            ]);
            return back()->with('success','Data update successfully');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }
    public function viewProduct($productID)
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'View Single Product'];
        try {
            $user = Auth::user();
            $categories = category::where('status',1)->get();
            $product = Product::where('id',$productID)->where('vendor_id',$user->id)->first();

            return \view('back-end.vendor.products.view',compact('categories','product','headerData'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        extract($request->post());
        $id = $product_id;
        if (product::where('id',$id)->where('vendor_id',Auth::user()->id)->delete())
            return back()->with('success','Data delete Successfully!');
        else
            return back()->with('error','Data delete not possible');
    }

    // Product Category Start here
    public function createCategory(Request $request)
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'Add Product Category'];
        if ($request->isMethod('post'))
        {
            return $this->storeCategory($request);
        }else{
            return view('back-end.vendor.category.add-new',compact('headerData'));
        }
    }

    public function storeCategory(Request $request)
    {
        $auth = Auth::user();
        $request->validate([
            'cname' => ['required', 'string', 'max:255'],
            'cdescription' => ['string','sometimes','nullable'],
        ]);
        try {
            extract($request->post());
            if (category::where('c_name',$cname)->first())
            {
                return back()->with('warning','Category Name already exist in database')->withInput();
            }
            category::create([
                'vendor_id' => $auth->id,
                'creater_id' => $auth->id,
                'status' => 1,
                'c_name' => $cname,
                'c_description' => $cdescription,
            ]);
            return back()->with('success','Data save successfully');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }

    public function showCategory()
    {
        $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'Product Category List'];
        $categories = category::leftJoin('users as v','v.id','categories.vendor_id')->leftJoin('users as c','c.id','categories.creater_id')->select('v.name as vendor_name','c.name as creater_name','categories.*')->where('categories.vendor_id',Auth::user()->id)->orderBY('categories.id','desc')->get();// v as vendor and c as creater

        return \view('back-end.vendor.category.show-list',compact('headerData','categories'));
    }

    public function viewCategory($categoryID)
    {
        try {
            $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'Product Category List'];
            $category = category::leftJoin('users as v','v.id','categories.vendor_id')->leftJoin('users as c','c.id','categories.creater_id')->select('categories.id','categories.c_name as category_name','categories.c_description as category_description','v.name as vendor_name','c.name as creater_name')->where('categories.vendor_id',Auth::user()->id)->where('categories.id',$categoryID)->first();// v as vendor and c as creater
            return \view('back-end.vendor.category.view',compact('headerData','category'));
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }

    public function editCategory(Request $request,$categoryID)
    {
        if ($request->isMethod('post'))
        {
            return $this->updateCategory($request);
        }else{
            try {
                $headerData = ['app'=>'Community Shopping','role'=>'vendor','title'=>'Product Category List'];
                $category = category::leftJoin('users as v','v.id','categories.vendor_id')->leftJoin('users as c','c.id','categories.creater_id')->select('categories.id','categories.c_name as category_name','categories.c_description as category_description','categories.status')->where('categories.vendor_id',Auth::user()->id)->where('categories.id',$categoryID)->first();// v as vendor and c as creater
                return \view('back-end.vendor.category.edit',compact('headerData','category'));
            }catch (\Throwable $exception)
            {
                return back()->with('error',$exception->getMessage())->withInput();
            }
        }
    }

    public function updateCategory(Request $request)
    {
        $auth = Auth::user();
        $request->validate([
            'cname' => ['required', 'string', 'max:255'],
            'status' => ['required','numeric'],
            'cdescription' => ['string','sometimes','nullable'],
        ]);
        try {
            extract($request->post());
            if (!($status == 0 || $status == 1))
            {
                return back()->with('error','Invalid status value')->withInput();
            }
            if (category::where('id','!=',$category_id)->where('c_name',$cname)->first())
            {
                return back()->with('warning','Category Name already exist in database')->withInput();
            }
            category::where('id',$category_id)->where('vendor_id',Auth::user()->id)->update([

                'status' => $status,
                'c_name' => $cname,
                'c_description' => $cdescription,
            ]);
            return back()->with('success','Data Update successfully');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }

    public function destroyCategory(Request $request)
    {
        extract($request->post());
        $id = $category_id;
        if (category::where('id',$id)->where('vendor_id',Auth::user()->id)->delete())
            return back()->with('success','Data delete Successfully!');
        else
            return back()->with('error','Data delete not possible');
    }
}
