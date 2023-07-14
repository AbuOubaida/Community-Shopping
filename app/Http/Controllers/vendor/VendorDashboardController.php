<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Models\communities;
use App\Models\order;
use App\Models\shop_info;
use App\Models\user;
use App\Models\vendor_community_list;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class VendorDashboardController extends Controller
{
    public $user_info = null;
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
                        return $this->myShop();
                    }
                    return $next($request);
                }
                else {
                    return $this->createShop($request);
                }
            });
        }catch (\Throwable $exception)
        {
            return back();
        }

    }
    public function createShop(Request $request)
    {
        $user = Auth::user();
        $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Create Shop'];
        if (shop_info::where("owner_id",$user->id)->first())
        {
            return redirect()->route('edit.shop');
        }
        if ($request->isMethod('post'))
        {
            return $this->storeShop($request);
        }else{
            $countries = null;
            try {
                $countries = DB::table('countries')->distinct()->get();
                return response()->view('back-end.vendor.shop.add-new',compact('headerData','countries'));
            }catch (\Throwable $exception)
            {
                return back()->with('error',$exception->getMessage());
            }
        }
    }
    private function storeShop(Request $request)
    {
        $profile_image_path = 'assets/back-end/vendor/profile/';
        $cover_image_path = 'assets/back-end/vendor/cover/';
        $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'shop_phone' => ['required', 'numeric'],
            'shop_email' => ['sometimes', 'nullable', 'regex:/(.+)@(.+)\.(.+)/i'],
            'country' => ['required', 'string'],
            'division' => ['required', 'string'],
            'district' => ['required', 'string'],
            'upazila' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'union' => ['sometimes', 'nullable', 'string'],
            'word_no' => ['sometimes', 'nullable', 'string'],
            'village' => ['sometimes', 'nullable', 'string'],
            'home' => ['sometimes', 'nullable', 'string'],
            'open' => ['sometimes', 'nullable', 'string'],
            'close' => ['sometimes', 'nullable', 'string'],
            'profile' => ['mimes:jpeg,jpg,png,gif','sometimes','nullable','max:10000'],// Product Image maximum size 10MB
            'cover' => ['mimes:jpeg,jpg,png,gif','sometimes','nullable','max:10000'],// Product Image maximum size 10MB
        ]);
        try {
            $user = Auth::user();
            $img_name_profile = null;
            $img_name_cover = null;
            // If shop does not exist then Insert Only Initial login time.
            extract($request->post());
            // If has profile image of shop
            if (shop_info::where("owner_id",$user->id)->first())
            {
                return redirect()->route('edit.shop');
            }
            if (shop_info::where("shop_name","=",$shop_name)->first())
            {
                return back()->with('warning','Shop name is already exist in out Database. Please try another Shop Name')->withInput();
            }
            if ($request->hasFile('profile'))
            {
                extract($request->file());
                if (@$profile)
                {
                    try {
                        $ext = $profile->getClientOriginalExtension();
                        $img_name_profile = str_replace(' ','_profile_',$shop_name).'_'.rand(111,99999).'_'.$profile->getClientOriginalName();
                        $imageUploadPathProfile = $profile_image_path.$img_name_profile;

                        Image::make($profile)->save($imageUploadPathProfile);
                    }catch (\Throwable $exception)
                    {
                        return back()->with('error',$exception->getMessage())->withInput();
                    }
                }
            }
            // If has cover image of shop
            if ($request->hasFile('cover'))
            {
                extract($request->file());
                if (@$cover)
                {
                    try {
                        $ext = $cover->getClientOriginalExtension();
                        $img_name_cover = str_replace(' ','_',$shop_name).'_cover_'.rand(111,99999).'_'.$cover->getClientOriginalName();
                        $imageUploadPathCover = $cover_image_path.$img_name_cover;

                        Image::make($cover)->save($imageUploadPathCover);
                    }catch (\Throwable $exception)
                    {
                        return back()->with('error',$exception->getMessage())->withInput();
                    }
                }
            }

            shop_info::create([
                'owner_id'  => $user->id,
                'creater_id'  => $user->id,
                'shop_name'  => $shop_name,
                'status'  => 1,// 5 = inactive, 2 = incomplete, 1 = active
                'delete_status'  => 0, //0 = not deleted, 1 = deleted
                'shop_phone'  => $shop_phone,
                'open_at'  => $open,
                'closed_at'  => $close,
                'shop_email'  => $shop_email,
                'home'  => $home,
                'village'  => $village,
                'word'  => $word_no,
                'union'  => $union,
                'upazila'  => $upazila,
                'district'  => $district,
                'zip_code'  => $zip_code,
                'division'  => $division,
                'country'  => $country,
                'shop_profile_image'  => $img_name_profile,
                'profile_image_path'  => $profile_image_path,
                'shop_cover_image'  => $img_name_cover,
                'cover_image_path' => $cover_image_path
            ]);
            return back()->with('success','Data save successfully');

        } catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }
    public function myShop(){
        try {
            $user = Auth::user();
            $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'My Shop'];
            if($myshop = shop_info::where('owner_id',$user->id)->where('status',1)->first())
            {
                return view('back-end.vendor.shop.view',compact('headerData','myshop'));
            }else {
                return redirect()->route('edit.shop');
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }

    public function editShop(Request $request)
    {
        $user = Auth::user();
        $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Edit My Shop'];
        if ($myshop = shop_info::where("owner_id",$user->id)->first())
        {
            if ($request->isMethod('post'))
            {
                return $this->updateShop($request);
            }else{
                $countries = null;
                try {
                    $countries = DB::table('countries')->distinct()->get();
                    return response()->view('back-end.vendor.shop.edit',compact('headerData','countries','myshop'));

                }catch (\Throwable $exception)
                {
                    return back()->with('error',$exception->getMessage());
                }
            }
        }
        else {
            return redirect()->route('create.shop');
        }
    }
    private function updateShop(Request $request)
    {
        $profile_image_path = 'assets/back-end/vendor/profile/';
        $cover_image_path = 'assets/back-end/vendor/cover/';
        $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'shop_phone' => ['required', 'numeric'],
            'shop_email' => ['sometimes', 'nullable', 'regex:/(.+)@(.+)\.(.+)/i'],
            'country' => ['required', 'string'],
            'division' => ['required', 'string'],
            'district' => ['required', 'string'],
            'upazila' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'union' => ['sometimes', 'nullable', 'string'],
            'word_no' => ['sometimes', 'nullable', 'string'],
            'village' => ['sometimes', 'nullable', 'string'],
            'home' => ['sometimes', 'nullable', 'string'],
            'open' => ['sometimes', 'nullable', 'string'],
            'close' => ['sometimes', 'nullable', 'string'],
            'profile' => ['mimes:jpeg,jpg,png,gif','sometimes','nullable','max:10000'],// Product Image maximum size 10MB
            'cover' => ['mimes:jpeg,jpg,png,gif','sometimes','nullable','max:10000'],// Product Image maximum size 10MB
        ]);
        try {
            $user = Auth::user();
            $img_name_profile = null;
            $img_name_cover = null;
            // If shop does not exist then Insert Only Initial login time.
            extract($request->post());
            // If has profile image of shop
            $myshop = shop_info::where('owner_id',$user->id)->first();
            if (shop_info::where("shop_name","=",$shop_name)->where("owner_id","!=",$user->id)->first())
            {
                return back()->with('warning','Shop name is already exist in out Database. Please try another Shop Name')->withInput();
            }
            $img_name_profile = $myshop->shop_profile_image;
            if ($request->hasFile('profile'))
            {
                extract($request->file());
                if (@$profile)
                {
                    $ext = $profile->getClientOriginalExtension();
                    $img_name_profile = str_replace(' ','_profile_',$shop_name).'_'.rand(111,99999).'_'.$profile->getClientOriginalName();
                    $imageUploadPathProfile = $profile_image_path.$img_name_profile;
                    if ($myshop->shop_profile_image && file_exists($name = $profile_image_path.$myshop->shop_profile_image))
                    {
                        unlink(public_path($name));
                    }
                    Image::make($profile)->save($imageUploadPathProfile);

                }
            }
            // If has cover image of shop
            $img_name_cover = $myshop->shop_cover_image;
            if ($request->hasFile('cover'))
            {
                extract($request->file());
                if (@$cover)
                {
                    $ext = $cover->getClientOriginalExtension();
                    $img_name_cover = str_replace(' ','_',$shop_name).'_cover_'.rand(111,99999).'_'.$cover->getClientOriginalName();
                    $imageUploadPathCover = $cover_image_path.$img_name_cover;
                    if ($myshop->shop_cover_image && file_exists($name = $cover_image_path.$myshop->shop_cover_image))
                    {
                        unlink(public_path($name));
                    }
                    Image::make($cover)->save($imageUploadPathCover);
                }
            }

            shop_info::where("owner_id",$user->id)->update([
                'owner_id'  => $user->id,
                'creater_id'  => $user->id,
                'shop_name'  => $shop_name,
                'status'  => 1,// 5 = inactive, 2 = incomplete, 1 = active
                'delete_status'  => 0, //0 = not deleted, 1 = deleted
                'shop_phone'  => $shop_phone,
                'open_at'  => $open,
                'closed_at'  => $close,
                'shop_email'  => $shop_email,
                'home'  => $home,
                'village'  => $village,
                'word'  => $word_no,
                'union'  => $union,
                'upazila'  => $upazila,
                'district'  => $district,
                'zip_code'  => $zip_code,
                'division'  => $division,
                'country'  => $country,
                'shop_profile_image'  => $img_name_profile,
                'profile_image_path'  => $profile_image_path,
                'shop_cover_image'  => $img_name_cover,
                'cover_image_path' => $cover_image_path,
//                'updated_at' => $user->id,
            ]);
            return back()->with('success','Data update successfully');

        } catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Dashboard'];
        return view('back-end.vendor.dashboard',compact('headerData'));
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
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        //
    }

    public function myCommunity(Request $request)
    {
        try {
            if ($request->isMethod('post'))
            {
                return $this->myCommunityStore($request);
            }
            else
            {
                $user = Auth::user();
                $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Dashboard'];
                extract($user->toArray());
                $comm = communities::where('village',$village)->where('word',$word)->where('union',$union)->where('upazila',$upazila)->where('district',$district)->where('division',$division)->where('village','!=',null)->where('status',1)->get();
                if (count($comm) == 0)
                {
                    $comm = communities::where('word',$word)->where('union',$union)->where('upazila',$upazila)->where('district',$district)->where('division',$division)->where('word','!=',null)->where('status',1)->get();
                    if (count($comm) == 0)
                    {
                        $comm = communities::where('union',$union)->where('upazila',$upazila)->where('district',$district)->where('division',$division)->where('union','!=',null)->where('status',1)->get();
                        if (count($comm) == 0)
                        {
                            $comm = communities::where('upazila',$upazila)->where('district',$district)->where('division',$division)->where('upazila','!=',null)->where('status',1)->get();
                            if (count($comm) == 0)
                            {
                                $comm = communities::where('district',$district)->where('division',$division)->where('district','!=',null)->where('status',1)->get();
                                if (count($comm) == 0)
                                {
                                    $comm = communities::where('division',$division)->where('division','!=',null)->where('status',1)->get();
                                    if (count($comm) == 0)
                                    {
                                        $comm == null;
                                    }
                                }
                            }
                        }
                    }
                }
                $vendor_communities = vendor_community_list::leftJoin('communities as c','c.id','vendor_community_lists.community_id')->where('vendor_community_lists.vendor_id',$user->id)->where('vendor_community_lists.status',1)->select('c.community_name as community','c.community_type','c.village','c.home','c.word','c.union','c.upazila','c.district','c.division','c.country','vendor_community_lists.*')->get();
                return view('back-end.vendor.community.view-community',compact('headerData','comm','vendor_communities'));
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    private function myCommunityStore(Request $request)
    {
        try {
            $request->validate([
                'community'  => ['required', 'numeric',],
                'remarks'  => ['nullable','sometimes','string'],
            ]);
            extract($request->post());
            $user = Auth::user();
            if (!(communities::where('id',$community)->where('status',1)->where('delete_status',0)->first()))
            {
                return back()->with('error','Community not found in database!');
            }
            if (vendor_community_list::where('vendor_id',$user->id)->where('community_id',$community)->first())
            {
                if (vendor_community_list::where('vendor_id',$user->id)->where('status','!=',1)->where('community_id',$community)->first())
                {
                    vendor_community_list::where('vendor_id',$user->id)->where('community_id',$community)->update([
                        'status'    =>  1,
                        'community_id'  =>  $community,
                        'remarks'       =>  $remarks,
                    ]);
                    return back()->with('success','Data save successfully!');
                }
                return back()->with('warning','Data already exist in database!');
            }
            vendor_community_list::create([
                'status'    =>  1,
                'vendor_id'     =>  $user->id,
                'community_id'  =>  $community,
                'remarks'       =>  $remarks,
            ]);
            return back()->with('success','Data save successfully!');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function deleteCommunity(Request $request)
    {
        $request->validate([
            'id'  => ['required', 'string',]
        ]);
        $user = Auth::user();
        extract($request->post());
        $id = Crypt::decryptString($id);
        vendor_community_list::where('id',$id)->where('vendor_id',$user->id)->update([
            'status'    =>  0,
        ]);
        return back()->with('success','Data delete successfully!');
    }


}
