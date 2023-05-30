<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\shipping_charges;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProtocolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function setShippingCharge(Request $request)
    {
        try {
            $user = Auth::user();
            $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Set Shipping Charge'];
            $countries = DB::table('countries')->distinct()->get();
            if ($request->isMethod('post'))
            {
                return $this->setShippingChargeStore($request);
            }else{
                $data = $this->getShippingCharge();
                return view('back-end.superadmin.protocol.shipping-charge.set-new',compact('headerData','countries','data'));
            }
        }catch (\Throwable $exception)
        {
            return back();
        }

    }

    public function setShippingChargeStore(Request $request)
    {
        try {
            extract($request->post());
            $user = Auth::user();
//            if ($location == 'all')
//            {
//                $datas = null;
//                if ($type == 1)
//                {
//                    //Country
//                    $datas = DB::table('countries')->select('nicename as name')->distinct()->get();
//                }elseif ($type == 2)
//                {
//                    //Division
//                    $datas = DB::table('divisions')->select('name')->distinct()->get();
//                }elseif ($type == 3)
//                {
//                    //District
//                    $datas = DB::table('districts')->select('name')->distinct()->get();
//                }elseif ($type == 4)
//                {
//                    //Upazila
//                    $datas = DB::table('upazilas')->select('name')->distinct()->get();
//                }elseif ($type == 5)
//                {
//                    //Union
//                    $datas = DB::table('unions')->select('name')->distinct()->get();
//                }else{
//                    $datas = null;
//                }
//                //datas
//                if(count($datas))
//                {
//                    foreach ($datas as $d)
//                    {
//                        if (!(shipping_charges::where("location_name",$d->name)->where('location_type',$type)->first()))
//                        {
//                            shipping_charges::create([
//                                'location_name' =>  $d->name,
//                                'location_type' =>  $type,
//                                'amount'        =>  $amount,
//                                'create_by'     =>  $user->id
//                            ]);
//                        }
//                    }
//                    $data = $this->getShippingCharge();
//                    return view('back-end.superadmin.protocol.shipping-charge._list',compact('data'));
//                }else{
//                    echo json_encode(array(
//                        'error' => array(
//                            'msg' => 'Something want wrong!',
//                            'code' => 500,
//                        )
//                    ));
//                }
//            }else
//            {
                if (!(shipping_charges::where('location_name',$location)->where('location_type',$type)->first()))
                {
                    shipping_charges::create([
                        'location_name' =>  $location,
                        'location_type' =>  $type,
                        'amount'        =>  $amount,
                        'create_by'     =>  $user->id
                    ]);
                    $data = $this->getShippingCharge();
                    return view('back-end.superadmin.protocol.shipping-charge._list',compact('data'));
                }else {
                    echo json_encode(array(
                        'error' => array(
                            'msg' => 'Duplicate Entry!',
                            'code' => 409,
                        )
                    ));
                }
//            }
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
    private function getShippingCharge()
    {
        try {
            return shipping_charges::distinct()->orderBy('location_type',"ASC")->get();
        }catch (\Throwable $exception)
        {
            echo "<script> alert(".json_encode(array(
                    'error' => array(
                        'msg' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                    )
                )).")</script>";
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\shipping_charges  $shipping_charges
     * @return \Illuminate\Http\Response
     */
    public function show(shipping_charges $shipping_charges)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\shipping_charges  $shipping_charges
     * @return \Illuminate\Http\Response
     */
    public function edit(shipping_charges $shipping_charges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\shipping_charges  $shipping_charges
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shipping_charges $shipping_charges)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\shipping_charges  $shipping_charges
     * @return \Illuminate\Http\Response
     */
    public function destroy(shipping_charges $shipping_charges)
    {
        //
    }
}
