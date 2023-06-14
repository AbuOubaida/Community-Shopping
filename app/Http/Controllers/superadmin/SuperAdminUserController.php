<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\shop_info;
use App\Models\User;
use http\Exception\BadConversionException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;
use TheSeer\Tokenizer\Exception;

class SuperAdminUserController extends Controller
{
    private $productImage = "assets/img/profile/";
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
        $headerData = ['app'=>'Community Shopping','role'=>'admin','title'=>'Add User'];
        if ($request->isMethod('post'))
        {
            return $this->store($request);
        }else{
            $countries = null;
            try {
                $countries = DB::table('countries')->distinct()->get();
                $roles = DB::table('roles')->distinct()->get();
            }catch (\Throwable $exception)
            {
                return back()->with('error', $exception->getMessage());
            }
            return view('back-end.superadmin.users.add-new',compact('countries','roles','headerData'));
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
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['sometimes','nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'numeric', 'unique:'.User::class],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'numeric'],
            'religion' => ['string','sometimes','nullable'],
            'home'  => ['string','sometimes','nullable', 'max:255'],
            'village' => ['string','sometimes','nullable', 'max:255'],
            'word_no' => ['string','sometimes','nullable', 'max:255'],
            'union' => ['string','sometimes','nullable', 'max:255'],
            'upazila' => ['string','sometimes','nullable', 'max:255'],
            'district' => ['string','sometimes','nullable', 'max:255'],
            'zip_code' => ['string','sometimes','nullable', 'max:255'],
            'division' => ['string','sometimes','nullable', 'max:255'],
            'country' => ['string','sometimes','nullable', 'max:255'],
            'roles' => ['required','string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile' => ['mimes:jpeg,jpg,png,gif,webp|sometimes|nullable|max:20000'],
        ]);

        try {
            extract($request->post());
            $img_name = null;
            if ($request->hasFile('profile')) {
                extract($request->file());
                if (@$profile)
                {
                    try {
                        $ext = $profile->getClientOriginalExtension();
                        $img_name = str_replace(' ','_',$fname).'_'.rand(111,99999).'_'.$profile->getClientOriginalName();
                        $imageUploadPath = $this->productImage.$img_name;
                        Image::make($profile)->save($imageUploadPath);
                    }catch (\Throwable $exception)
                    {
                        return back()->with('error',$exception->getMessage())->withInput();
                    }
                }
            }
            $user = User::create([
                'status' => 1,
                'fname' => $fname,
                'lname' => $lname,
                'name' => $fname.' '.$lname,
                'email' => $email,
                'phone' => $phone,
                'gender' => $gender,
                'religion' => $religion,
                'dob' => $dob,
                'home' => $home,
                'village' => $village,
                'word' => $word_no,
                'union' => $union,
                'upazila' => $upazila,
                'district' => $district,
                'zip_code' => $zip_code,
                'division' => $division,
                'country' => $country,
                'password' => Hash::make($request->password),
                'img_path' => $this->productImage,
                'img_name' => $img_name,
            ]);
            if (DB::table('roles')->where('name',$roles)->first())
            {
                $user->attachRole($roles);
                event(new Registered($user));
                return back()->with('success','Account create successfully');
            }else{
                return back()->with('error','Invalid User Roles')->withInput();
            }
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
        $headerData = ['app'=>'Community Shopping','role'=>'admin','title'=>'User List'];
        $AuthUser = Auth::user();
        $userList = user::leftJoin('role_user as r_user','users.id','=','r_user.user_id')->leftJoin('roles as r','r_user.role_id','r.id')->where('users.id','!=',$AuthUser->id)->where('delete_status',0)->select('r.name as role_name','r.id as role_id','users.*')->get();
        return view('back-end.superadmin.users.show-list',compact('userList','headerData'));
    }

    public function singleViewUser($id)
    {
        try {
            $userId = Crypt::decryptString($id);
            if ($user = User::leftJoin('role_user as r_user','users.id','=','r_user.user_id')->leftJoin('roles as r','r_user.role_id','r.id')->where('users.id',$userId)->select('r.display_name as role','users.*')->first())
            {
                $userShop = null;
                if ($user->role == 'Vendor')
                {
                    $userShop = shop_info::where('owner_id',$user->id)->get();
                }
                return view('back-end/superadmin/users/view-user',compact('user','userShop'));
            }else{
                return back()->with('error','User not found!');
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $headerData = ['app'=>'Community Shopping','role'=>Auth::user()->roles->first()->display_name,'title'=>'Edit User Profile'];
            $countries = DB::table('countries')->distinct()->get();
            $roles = DB::table('roles')->distinct()->get();
            if ($request->isMethod('put'))
            {
                return $this->update($request);
            }
            else {
                $userId = Crypt::decryptString($id);
                if ($user = User::leftJoin('role_user as r_user','users.id','=','r_user.user_id')->leftJoin('roles as r','r_user.role_id','r.id')->where('users.id',$userId)->select('r.display_name as role','r.id as rid','users.*')->first())
                {
                    $userShop = null;
                    if ($user->role == 'Vendor')
                    {
                        $userShop = shop_info::where('owner_id',$user->id)->get();
                    }
                    //
                    $divisions = null;
                    if (strtolower($user->country) == strtolower('Bangladesh'))
                    {
                        $divisions = DB::table('divisions')->distinct()->get();
                    }
                    $districts = DB::table('districts')->distinct()->get();
                    $upazilas = DB::table('upazilas')->distinct()->get();
                    $zip_codes = DB::table('zip_codes')->distinct()->get();
                    $unions = DB::table('unions')->distinct()->get();
                    return view('back-end/superadmin/users/edit-user',compact('user','userShop','countries','roles','divisions','districts','upazilas','zip_codes','unions'));
                }else{
                    return back()->with('error','User not found!');
                }
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }

    }


    private function update(Request $request)
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['sometimes','nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'numeric'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'numeric'],
            'religion' => ['string','sometimes','nullable'],
            'home'  => ['string','sometimes','nullable', 'max:255'],
            'village' => ['string','sometimes','nullable', 'max:255'],
            'word_no' => ['string','sometimes','nullable', 'max:255'],
            'union' => ['string','sometimes','nullable', 'max:255'],
            'upazila' => ['string','sometimes','nullable', 'max:255'],
            'district' => ['string','sometimes','nullable', 'max:255'],
            'zip_code' => ['string','sometimes','nullable', 'max:255'],
            'division' => ['string','sometimes','nullable', 'max:255'],
            'country' => ['string','sometimes','nullable', 'max:255'],
            'roles' => ['required','string', 'max:255'],
            'profile' => ['mimes:jpeg,jpg,png,gif,webp|sometimes|nullable|max:20000'],
            'id' => ['required', 'string',],
        ]);
        try {
            extract($request->post());
            $id = Crypt::decryptString($id);
            if ($data = User::where('id','!=',$id)->where('email',$email)->first())
            {
                return back()->with('warning','Email duplicate in DB');
            }
            if ($data = User::where('id','!=',$id)->where('phone',$phone)->first())
            {
                return back()->with('warning','Phone number duplicate in DB');
            }
            $user = User::where('id',$id)->first();
            $img_name_profile = $user->img_name;
            if ($request->hasFile('profile'))
            {
                extract($request->file());
                if (@$profile)
                {

                    $ext = $profile->getClientOriginalExtension();
                    $img_name_profile = str_replace(' ','_',$fname).'_'.rand(111,99999).'_'.$profile->getClientOriginalName();
                    $imageUploadPath = $this->productImage.$img_name_profile;
                    if ($user->img_name && file_exists($name = $this->productImage.$user->img_name))
                    {
                        unlink(public_path($name));
                    }
                    Image::make($profile)->save($imageUploadPath);
                }
            }
            $me = Auth::user();
            $user = User::where('id',$id)->update([
                'fname' => $fname,
                'lname' => $lname,
                'name' => $fname.' '.$lname,
                'email' => $email,
                'phone' => $phone,
                'gender' => $gender,
                'religion' => $religion,
                'dob' => $dob,
                'home' => $home,
                'village' => $village,
                'word' => $word_no,
                'union' => $union,
                'upazila' => $upazila,
                'district' => $district,
                'zip_code' => $zip_code,
                'division' => $division,
                'country' => $country,
                'img_name' => $img_name_profile,
            ]);
            if (DB::table('roles')->where('id',$roles)->first())
            {
                DB::table('role_user')->where('user_id',$id)->update(['role_id'=>$roles]);
                return back()->with('success','Data update successfully');
            }else{
                return back()->with('error','Invalid User Roles')->withInput();
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        try {
            extract($request->post());
            $id = $user_id;
            if (user::where('id',$id)->update(['delete_status'=>1,'status'=>0,'update_by' => Auth::user()->id, ]))
                return redirect(route('super.admin.list.user'))->with('success','Data delete successfully!');
            else
                return back()->with('error','Data delete not possible');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }

    }
    public function rollback(Request $request)
    {
        try {
            extract($request->post());
            $id = $user_id;
            if (user::where('id',$id)->update(['delete_status'=>0,'status'=>1,'update_by' => Auth::user()->id, ]))
                return redirect(route('super.admin.list.user'))->with('success','Data rollback successfully!');
            else
                return back()->with('error','Data rollback not possible');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function statusUpdate(Request $request)
    {
        try {
            extract($request->post());
            $id = $user_id;
            if (user::where('id',$id)->update(['status'=>$status,'update_by' => Auth::user()->id, ]))
                return back()->with('success','Status update successfully!');
            else
                return back()->with('error','Status update not possible');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
    public function passwordUpdate(Request $request)
    {
        try {
            extract($request->post());
            $id = $user_id;
            if (user::where('id',$id)->update(['password'=>Hash::make($password),'update_by' => Auth::user()->id, ]))
                return back()->with('success','Password changed successfully!');
            else
                return back()->with('error','Password change not possible');
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }
}
