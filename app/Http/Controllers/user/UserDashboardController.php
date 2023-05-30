<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $headerData = ['app'=>'Online Food Delivery System','role'=>'user','title'=>'Dashboard'];
        return view('back-end.user.dashboard',compact('headerData'));
    }
}
