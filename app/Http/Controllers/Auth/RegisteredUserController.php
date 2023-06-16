<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

class RegisteredUserController extends Controller
{
    private $productImage = "assets/img/profile/";
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $headerData = ['app'=>'Community Shopping','role'=>'Client','title'=>'User Registration'];//page title[optional]
        $pageInfo = ['rootRoute'=>'root','root'=>'Home','parent'=>null,'parentRoute'=>null,'this'=>'User Registration'];
        $countries = null;
        try {
            $countries = DB::table('countries')->distinct()->get();
            $roles = DB::table('roles')->where('id','>','2')->distinct()->get();
            $userVill = User::select('village')->distinct()->get();
            $userWord = User::select('word')->distinct()->get();
        }catch (\Throwable $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
        return view('back-end.auth.register',compact('roles','countries','headerData','pageInfo','userWord','userVill'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
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
            'division' => ['string','required', 'max:255'],
            'country' => ['string','required', 'max:255'],
            'roles' => ['required','string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile' => ['mimes:jpeg,jpg,png,gif,webp|sometimes|nullable|max:20000'],
        ]);
        extract($request->post());
        $img_name = null;
        if ($request->hasFile('profile'))
        {
            extract($request->file());
//            dd($dob,$gender,$religion,$profile,$this->productImage);

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
        if ($roles == 'user') $status = 1; else $status = 0;
        try {
            $user = User::create([
                'status' => $status,
                'fname' => $fname,
                'lname' => $lname,
                'gender' => $gender,
                'religion' => $religion,
                'dob' => $dob,
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


//        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
