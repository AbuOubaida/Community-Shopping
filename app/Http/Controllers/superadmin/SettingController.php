<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\slider_images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    //
    private $sliderImageUrl = 'assets/slider-image/';

    public function createSlider(Request $request)
    {
        $user = Auth::user();
        $headerData = ['app'=>'Community Shopping','role'=>$user->roles->first()->display_name,'title'=>'Add Slider Image'];
        if ($request->isMethod('post'))
        {
            return $this->store($request);
        }else{

            $sliders = slider_images::where('status',1)->get();
            return view('back-end.superadmin.setting.slider.add-new',compact('headerData','sliders'));
        }
    }

    private function store(Request $request)
    {
        $img_name = null;
//        data validation
        $request->validate([
            'title' => ['nullable','sometimes', 'max:255'],
            'quotation' => ['nullable','sometimes','max:255'],
            'heading1' => ['nullable','sometimes', 'max:255'],
            'heading2' => ['nullable','sometimes','max:255'],
            'paragraph' => ['nullable','sometimes','max:255'],
            'button_title' => ['nullable','sometimes','max:255'],
            'button_link' => ['nullable','sometimes','max:255'],
            'image_name' => ['mimes:jpeg,jpg,png,gif|required|max:10000'],// Product Image maximum size 10MB
        ]);
        try {
            $title_show = 0;
            $quotation_show = 0;
            $heading1_show = 0;
            $heading2_show = 0;
            $paragraph_show = 0;
            $button_show = 0;
            $user = Auth::user();
            extract($request->post()); // make html name attr. to php variable
            // If product has image then
            if ($request->hasFile('image_name'))
            {
                extract($request->file());
                if (@$image_name)
                {
                    try {
                        $ext = $image_name->getClientOriginalExtension();
                        $img_name = str_replace(' ','_',$title).'_'.rand(111,99999).'_'.$image_name->getClientOriginalName();
                        $imageUploadPath = $this->sliderImageUrl.$img_name;

                        Image::make($image_name)->save($imageUploadPath);
                    }catch (\Throwable $exception)
                    {
                        return back()->with('error',$exception->getMessage())->withInput();
                    }

                    slider_images::create([
                        'created_id'    =>  $user->id,
                        'title'         =>  $title,
                        'title_show'    =>  $title_show,
                        'status'        =>  1,
                        'deleteStatus'  =>  0,
                        'quotation'     =>  $quotation,
                        'quotation_show'=>  $quotation_show,
                        'heading1'      =>  $heading1,
                        'heading1_show' =>  $heading1_show,
                        'heading2'      =>  $heading2,
                        'heading2_show' =>  $heading2_show,
                        'paragraph'     =>  $paragraph,
                        'paragraph_show'=>  $paragraph_show,
                        'button_title'  =>  $button_title,
                        'button_link'   =>  $button_link,
                        'button_show'   =>  $button_show,
                        'image_name'    =>  $img_name,
                        'source_url'    => $this->sliderImageUrl,
                    ]);
                    return back()->with('success','Image add successfully!');
                }
            }
            else{
                return back()->with('error','Image is not null!')->withInput();
            }
        }catch (\Throwable $exception)
        {
            return back()->with('error',$exception->getMessage())->withInput();
        }
    }
}
