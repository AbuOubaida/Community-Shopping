<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

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
        $userList = user::leftJoin('role_user as r_user','users.id','=','r_user.user_id')->leftJoin('roles as r','r_user.role_id','r.id')->where('users.id','!=',$AuthUser->id)->select('r.name as role_name','r.id as role_id','users.*')->get();
        return view('back-end.superadmin.users.show-list',compact('userList','headerData'));
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
    public function destroy(Request $request)
    {
        extract($request->post());
        $id = $user_id;
        if (user::where('id',$id)->delete())
            return back()->with('success','Data delete Successfully!');
        else
            return back()->with('error','Data delete not possible');
    }
}
