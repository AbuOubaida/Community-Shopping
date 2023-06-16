<?php

namespace App\Http\Controllers\community;

use App\Http\Controllers\Controller;
use App\Models\communities;
use App\Models\shop_info;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class CommunityController extends Controller
{
    public function __construct()
    {
        try {
            $this->middleware(function ($request,$next){
                $this->user_info = Auth::user();
                $community_info = communities::where('owner_id',$this->user_info->id)->first();
//                dd($community_info);
                if ($community_info)
                {
                    if ($community_info->status != 1)
                    {
                        return $this->myCommunity();
                    }
                    return $next($request);
                }
                else {
                    return $this->createCommunity($request);
                }
            });
        }catch (\Throwable $exception)
        {
            return back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headerData = ['app'=>'Online Food Delivery System','role'=>'Community','title'=>'Dashboard'];
        return view('back-end.community.dashboard',compact('headerData'));
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

    private function createCommunity(Request $request)
    {
        try {
            $user = Auth::user();
            $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Create Community'];
            if (communities::where("owner_id",$user->id)->first())
            {
                return redirect()->route('edit.community');
            }
            if ($request->isMethod('post'))
            {
                return $this->storeCommunity($request);
            }else{
                $countries = null;
                try {
                    $countries = DB::table('countries')->distinct()->get();
                    return response()->view('back-end.community.my-community.add-new',compact('headerData','countries','user'));
                }catch (\Throwable $exception)
                {
                    return back()->with('error',$exception->getMessage());
                }
            }
            return back();
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    private function storeCommunity(Request $request)
    {
        $profile_image_path = 'assets/back-end/community/profile/';
        $cover_image_path = 'assets/back-end/community/cover/';
        $request->validate([
            'community_name' => ['required', 'string', 'max:255'],
            'community_phone' => ['required', 'numeric'],
            'community_email' => ['sometimes', 'nullable', 'regex:/(.+)@(.+)\.(.+)/i'],
            'type' => ['required', 'string'],
            'country' => ['required', 'string'],
            'division' => ['required', 'string'],
            'district' => ['required', 'string'],
            'upazila' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'union' => ['sometimes', 'nullable', 'string'],
            'word_no' => ['sometimes', 'nullable', 'string'],
            'village' => ['sometimes', 'nullable', 'string'],
            'home' => ['sometimes', 'nullable', 'string'],
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
            if (communities::where("owner_id",$user->id)->first())
            {
                return redirect()->route('edit.community');
            }
            if (communities::where("community_name",$community_name)->where("village",$village)->where("union",$union)->first())
            {
                return back()->with('warning','Community name is already exist in out Database. Please try another Community Name')->withInput();
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

            communities::create([
                'owner_id'  => $user->id,
                'creater_id'  => $user->id,
                'community_name'  => $community_name,
                'community_type'  => $type,
                'status'  => 1,// 5 = inactive, 2 = incomplete, 1 = active
                'delete_status'  => 0, //0 = not deleted, 1 = deleted
                'community_phone'  => $community_phone,
                'community_email'  => $community_email,
                'home'  => $home,
                'village'  => $village,
                'word'  => $word_no,
                'union'  => $union,
                'upazila'  => $upazila,
                'district'  => $district,
                'zip_code'  => $zip_code,
                'division'  => $division,
                'country'  => $country,
                'community_profile_image'  => $img_name_profile,
                'profile_image_path'  => $profile_image_path,
                'community_cover_image'  => $img_name_cover,
                'cover_image_path' => $cover_image_path
            ]);
            return back()->with('success','Data save successfully');

        } catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }
    public function myCommunity(){
        try {
            $user = Auth::user();
            $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'My Community'];
            if($myCommunity = communities::where('owner_id',$user->id)->where('status',1)->first())
            {
                return view('back-end.community.my-community.view',compact('headerData','myCommunity'));
            }else {
                return redirect()->route('edit.community');
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }

    public function editCommunity(Request $request)
    {
        $user = Auth::user();
        $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Edit My Community'];
        if ($myCommunity = communities::where("owner_id",$user->id)->first())
        {
            if ($request->isMethod('post'))
            {
                return $this->updateCommunity($request);
            }else{
                $countries = null;
                try {
                    $countries = DB::table('countries')->distinct()->get();
                    return response()->view('back-end.community.my-community.edit',compact('headerData','countries','myCommunity'));

                }catch (\Throwable $exception)
                {
                    return back()->with('error',$exception->getMessage());
                }
            }
        }
        else {
            return redirect()->route('create.community');
        }
    }
    private function updateCommunity(Request $request)
    {
        $profile_image_path = 'assets/back-end/community/profile/';
        $cover_image_path = 'assets/back-end/community/cover/';
        $request->validate([
            'community_name' => ['required', 'string', 'max:255'],
            'community_phone' => ['required', 'numeric'],
            'community_email' => ['sometimes', 'nullable', 'regex:/(.+)@(.+)\.(.+)/i'],
            'country' => ['required', 'string'],
            'division' => ['required', 'string'],
            'district' => ['required', 'string'],
            'upazila' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'union' => ['sometimes', 'nullable', 'string'],
            'word_no' => ['sometimes', 'nullable', 'string'],
            'village' => ['sometimes', 'nullable', 'string'],
            'home' => ['sometimes', 'nullable', 'string'],
            'community_name' => ['required', 'string'],
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
            $myCommunity = communities::where('owner_id',$user->id)->first();
            if (communities::where("community_name",$community_name)->where("village",$village)->where("union",$union)->where("owner_id","!=",$user->id)->first())
            {
                return back()->with('warning','Community name is already exist in out Database. Please try another Shop Name')->withInput();
            }
            $img_name_profile = $myCommunity->community_profile_image;
            if ($request->hasFile('profile'))
            {
                extract($request->file());
                if (@$profile)
                {
                    $ext = $profile->getClientOriginalExtension();
                    $img_name_profile = str_replace(' ','_profile_',$community_name).'_'.rand(111,99999).'_'.$profile->getClientOriginalName();
                    $imageUploadPathProfile = $profile_image_path.$img_name_profile;
                    if ($myCommunity->community_profile_image && file_exists($name = $profile_image_path.$myCommunity->community_profile_image))
                    {
                        unlink(public_path($name));
                    }
                    Image::make($profile)->save($imageUploadPathProfile);

                }
            }
            // If has cover image of shop
            $img_name_cover = $myCommunity->community_cover_image;
            if ($request->hasFile('cover'))
            {
                extract($request->file());
                if (@$cover)
                {
                    $ext = $cover->getClientOriginalExtension();
                    $img_name_cover = str_replace(' ','_',$community_name).'_cover_'.rand(111,99999).'_'.$cover->getClientOriginalName();
                    $imageUploadPathCover = $cover_image_path.$img_name_cover;
                    if ($myCommunity->community_cover_image && file_exists($name = $cover_image_path.$myCommunity->community_cover_image))
                    {
                        unlink(public_path($name));
                    }
                    Image::make($cover)->save($imageUploadPathCover);
                }
            }

            communities::where("owner_id",$user->id)->update([
                'community_name'  => $community_name,
                'status'  => 1,// 5 = inactive, 2 = incomplete, 1 = active
                'delete_status'  => 0, //0 = not deleted, 1 = deleted
                'community_phone'  => $community_phone,
                'community_type'  => $community_name,
                'community_email'  => $community_email,
                'home'  => $home,
                'village'  => $village,
                'word'  => $word_no,
                'union'  => $union,
                'upazila'  => $upazila,
                'district'  => $district,
                'zip_code'  => $zip_code,
                'division'  => $division,
                'country'  => $country,
                'community_profile_image'  => $img_name_profile,
                'profile_image_path'  => $profile_image_path,
                'community_cover_image'  => $img_name_cover,
                'cover_image_path' => $cover_image_path,
//                'updated_at' => $user->id,
            ]);
            return back()->with('success','Data update successfully');

        } catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }
}
