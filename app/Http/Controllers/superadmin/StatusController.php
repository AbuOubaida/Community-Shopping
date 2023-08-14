<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\order_status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function setOrderStatus(Request $request)
    {
        try {
            if ($request->isMethod('post'))
            {
                //submit
                return $this->statusStore($request);
            }else{
                $statuses = order_status::orderBy('id','DESC')->get();
                return view('back-end/superadmin/protocol/status/set-new',compact('statuses'));
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function statusStore(Request $request)
    {
        try {
            if ($request->isMethod('post'))
            {
                $request->validate([
                    'statusName'    =>  ['required', 'string', 'max:255'],
                    'statusValue'   =>  ['required','numeric'],
                    'badge'         =>  ['required','string','max:255'],
                    'title'         =>  ['string','sometimes','nullable', 'max:255'],
                ]);
                extract($request->post());
                if (!(order_status::where('status_value',$statusValue)->first()))
                {
                    order_status::create([
                        'status_name'   =>  $statusName,
                        'status_value'  =>  $statusValue,
                        'badge'         =>  $badge,
                        'title'         =>  $title,
                    ]);
                    return back()->with('success','Data add successfully!');
                }else{
                    return back()->with('error','Status value already exist in database!');
                }
            }
        }catch (\Throwable $exception)
        {
            return back();
        }
    }
}
