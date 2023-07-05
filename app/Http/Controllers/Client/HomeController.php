<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = null;
        $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'Home Page'];
        $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>null,'parentRoute'=>null,'this'=>null];
        try {
            $categories = Product::leftJoin('categories as cate','cate.id','products.category_id')->select('cate.c_name as category_name','products.category_id')->orderBy("products.id", "DESC")->take(8)->get()->toArray();
            $uniques = array_map("unserialize", array_unique(array_map("serialize", $categories)));
            $products = Product::leftJoin('users as v','v.id','products.vendor_id')// v as for product vendor info from user table
            ->leftJoin('users as c','c.id','products.creater_id')// c as product creater info from user
            ->leftJoin('users as up','up.id','products.updater_id')// up as product updater info from user
            ->leftJoin('categories as cate','cate.id','products.category_id')//cate as categories table
            ->leftJoin('shop_infos as shop','shop.owner_id','v.id')//shop as shop_info table
            ->select('v.name as vendor_name','shop.shop_name as shop_name','shop.shop_profile_image as v_image','shop.profile_image_path as v_img_path','c.name as creater_name','up.name as updater_name','cate.c_name as category_name','products.*')
            ->where("products.p_status", 1)->where('p_image','!=',null)->orderBy("id", "DESC")->take(8)->get();

            $productLists = Product::leftJoin('users as v','v.id','products.vendor_id')// v as for product vendor info from user
            ->leftJoin('users as c','c.id','products.creater_id')// c as product creater info from user
            ->leftJoin('users as up','up.id','products.updater_id')// up as product updater info from user
            ->leftJoin('categories as cate','cate.id','products.category_id')//cate as categories table
            ->leftJoin('shop_infos as shop','shop.owner_id','v.id')//shop as shop_info table
            ->select('v.name as vendor_name','shop.shop_name as shop_name','shop.shop_profile_image as v_image','shop.profile_image_path as v_img_path','c.name as creater_name','up.name as updater_name','cate.c_name as category_name','products.*')
                ->where("products.p_status", 1)->where('p_image','!=',null)->orderBy("id", "ASC")->take(4)->get();
//            dd($productLists);
            return view('client-site.home',compact('uniques','headerData','products','productLists','pageInfo'));

        }catch (\Throwable $exception)
        {
            return $exception->getCode();
        }

    }
    public function about()
    {
        $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'About Page'];
        $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>null,'parentRoute'=>null,'this'=>'About'];
        return view('client-site.about',compact('headerData','pageInfo'));
    }
    public function contact()
    {
        $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'Contact'];
        $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>null,'parentRoute'=>null,'this'=>'Contact'];
        return view('client-site.contact',compact('headerData','pageInfo'));
    }
}
