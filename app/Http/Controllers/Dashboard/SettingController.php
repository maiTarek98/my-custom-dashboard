<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Setting;
use DB;
class SettingController extends Controller
{

public function __construct() {
        $this->middleware('permission:edit-setting')->only('index','update');
    }
    public function index(){
        $setting= Setting::findOrFail(1);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'website_name' => 'required|string',
            'website_bio' => 'required|string',
            'website_icon' => 'sometimes|nullable|image',
            'website_logo' => 'sometimes|nullable|image',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'whatsapp_phone' => 'required|string',
            'facebook_link' => 'sometimes|nullable|url',
            'twitter_link' => 'sometimes|nullable|url',
            'tiktok_link' => 'sometimes|nullable|url',
            'instagram_link' => 'sometimes|nullable|url',
            'linkedin_link' => 'sometimes|nullable|url',
            'telegram_link' => 'sometimes|nullable|url',
            'youtube_link' => 'sometimes|nullable|url',
            'whatsapp_link' => 'sometimes|nullable|url',
        ]);
   
        $up_setting=Setting::where('id',$id)->update($request->except('_method','_token'));
        return redirect()->back()->withSuccess('Setting Updated Successfully');

    }

}
