<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headerData = ['app'=>'Online Food Delivery System','role'=>'admin','title'=>'Dashboard'];
        return view('back-end.admin.dashboard',compact('headerData'));
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
            return view('back-end.admin.users.add-new',compact('countries','roles','headerData'));
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
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'numeric', 'unique:'.User::class],
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
        ]);

        try {
            extract($request->post());
            $user = User::create([
                'status' => 1,
                'fname' => $fname,
                'lname' => $lname,
                'name' => $fname.' '.$lname,
                'email' => $email,
                'phone' => $phone,
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
        $userList = user::leftJoin('role_user as r_user','users.id','=','r_user.user_id')->leftJoin('roles as r','r_user.role_id','r.id')->where('users.id','!=',$AuthUser->id)->where(function ($query) use ($AuthUser) {
            $query->where('users.district',$AuthUser->district);
            $query->orWhere('users.upazila',$AuthUser->upazila);
            })->select('r.name as role_name','r.id as role_id','users.*')->get();
        return view('back-end.admin.users.show-list',compact('userList','headerData'));
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
