<?php

namespace App\Http\Controllers;

use App\Http\Controllers\client\ClientProductController;
use App\Models\communities;
use App\Models\shipping_charges;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxRequestController extends Controller
{
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    public function getDivision(Request $request)
    {
        try {
            extract($request->post());
            if (isset($value) && (strtolower($value) == strtolower("Bangladesh")))
            {
                $results = DB::table('divisions')->select('id','name')->get();
                echo json_encode(array(
                    'results' => $results
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
    public function getDistrict(Request $request)
    {
        try {
            extract($request->post());
            $division = DB::table('divisions')->where('name',$value)->select('id')->first();
//            echo $division->id;
            $districts = DB::table('districts')->where('division_id',$division->id)->select('name','bn_name')->get();
            echo json_encode(array(
                'results' => $districts
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
    }
    public function getUpazila(Request $request)
    {
        try {
            extract($request->post());
            $district = DB::table('districts')->where('name',$value)->select('id','name')->first();
//            echo $division->id;
            $upazilas = DB::table('upazilas')->where('district_id',$district->id)->select('name as name')->distinct('name')->get()->toArray();
            $citys = DB::table('city_corporations')->Where('district','like',"%$district->name%")->select('name')->distinct()->get()->toArray();
            echo json_encode(array(
                'results' => $upazilas,
                'results2' => $citys,
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
    }
    public function getZip(Request $request)
    {
        $zipCods = null;
        $unions = null;
        try {
            extract($request->post());

            if ($upazilla = DB::table('upazilas')->where('name',$value)->select('name','id','district_id')->first())
            {
                $zipCods = DB::table('zip_codes')->where('Thana',$upazilla->name)->select('PostCode','SubOffice')->get();
                $zilla = DB::table('districts')->where('id',$upazilla->district_id)->select('name')->first();
                $unions = DB::table('unions')->where('upazilla_id',$upazilla->id)->select('name','bn_name')->get();
            }
            else{
                $cities = DB::table('city_corporations')->where('name','like',"%$value%")->select('District')->first();
                $zilla = DB::table('districts')->where('name','like',"%$cities->District%")->select('name')->first();
            }

            if ($zipCods == null)
            {
                $zipCods = DB::table('zip_codes')->where(function ($query) use($zilla){
                    $query->where('District',$zilla->name);
                })->select('PostCode','SubOffice')->get();
            }
            echo json_encode(array(
                'zipCods' => $zipCods,
                'unions'  => $unions,
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
    }

    public function LocationType(Request $request)
    {
        try {
            extract($request->post());
            $data = null;
            if (isset($value))
            {
                if ($value == 1)
                {
                    $data = DB::table('countries')->select('nicename as name')->distinct()->orderBy('nicename','ASC')->get();
                }
                else if ($value == 2)
                {
                    $data = DB::table('divisions')->select('name')->distinct()->orderBy('name','ASC')->get();
                }
                else if ($value == 3)
                {
                    $data = DB::table('districts')->select('name')->distinct()->orderBy('name','ASC')->get();
                }
                else if ($value == 4)
                {
                    $data = DB::table('upazilas')->select('name')->distinct()->orderBy('name','ASC')->get();
                }
                else if ($value == 5)
                {
                    $data = DB::table('unions')->select('name')->distinct()->orderBy('name','ASC')->get();
                }
            }
            return view('back-end.superadmin.protocol.shipping-charge._options',compact('data'));
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

    public function changeAddress(Request $request)
    {
        try {
            if ($request->post())
            {
                $comm = null;
                $shippingCharge = null;
                extract($request->post());
                if ($user = Auth::user())
                {
                    if ($union)
                    {
                        if (!($shippingCharge = shipping_charges::where('location_name',$union)->where('location_type',5)->first()))
                        {
                            $shippingCharge = shipping_charges::where('location_name',"all")->where('location_type',5)->first();
                        }
                    }
                    if (!($shippingCharge) && $upazila)
                    {
                        if (!($shippingCharge = shipping_charges::where('location_name',$upazila)->where('location_type',4)->first()))
                        {
                            $shippingCharge = shipping_charges::where('location_name',"all")->where('location_type',4)->first();
                        }
                    }
                    if (!($shippingCharge) && $district)
                    {
                        if (!($shippingCharge = shipping_charges::where('location_name',$district)->where('location_type',3)->first()))
                        {
                            $shippingCharge = shipping_charges::where('location_name',"all")->where('location_type',3)->first();
                        }
                    }
                    if (!($shippingCharge) && $division)
                    {
                        if (!($shippingCharge = shipping_charges::where('location_name',$division)->where('location_type',2)->first()))
                        {
                            $shippingCharge = shipping_charges::where('location_name',"all")->where('location_type',2)->first();
                        }
                    }
                    if (!($shippingCharge) && $country)
                    {
                        if (!($shippingCharge = shipping_charges::where('location_name',$country)->where('location_type',1)->first()))
                        {
                            $shippingCharge = shipping_charges::where('location_name',"all")->where('location_type',1)->first();
                        }
                    }
                    if (!($shippingCharge))
                    {
                        echo json_encode(array(
                            'error' => array(
                                'msg' => "Not Found!",
                                'code' => 404,
                            )
                        ));
                    }

                    $comm = self::communityGet($request);
                }
                $total = 0;
                if(\session('cart'))
                {
                    foreach(session('cart') as $id => $details)
                    {
                        $total += $details['price'] * $details['quantity'];
                    }
                }
                return view('layouts/front-end/_card_total',compact('total','shippingCharge','comm'));
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
    public static function communityGet(Request $request)
    {
        try {
            $record = 4;
            extract($request->post());
            $comm = communities::where('village',$village)->where('village','!=',null)->where('status',1)->get();
            if (count($comm) == 0)
            {
                $comm = communities::where('word',$word)->where('word','!=',null)->where('status',1)->take($record)->get();
                if (count($comm) == 0)
                {
                    $comm = communities::where('union',$union)->where('union','!=',null)->where('status',1)->take($record)->get();
                    if (count($comm) == 0)
                    {
                        $comm = communities::where('upazila',$upazila)->where('upazila','!=',null)->where('status',1)->take($record)->get();
                        if (count($comm) == 0)
                        {
                            $comm = communities::where('district','like',"%$district%")->where('district','!=',null)->where('status',1)->take($record)->get();
                            if (count($comm) == 0)
                            {
                                $comm = communities::where('division',$division)->where('division','!=',null)->where('status',1)->take($record)->get();
                            }
                            else{
                                $comm = null;
                            }
                        }
                    }
                }
            }
            return $comm;
        }catch (\Throwable $exception)
        {
            return $exception;
        }

    }
}
