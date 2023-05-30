<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class routeController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('superadmin'))
        {
            return redirect()->route('super.admin.dashboard');
        }elseif (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }elseif (Auth::user()->hasRole('user')) {
            return redirect()->route('user.dashboard');
        }elseif (Auth::user()->hasRole('vendor')) {
            return redirect()->route('vendor.dashboard');
        }elseif (Auth::user()->hasRole('community')) {
            return redirect()->route('community.dashboard');
        }
        return redirect()->route('root');
    }
}
