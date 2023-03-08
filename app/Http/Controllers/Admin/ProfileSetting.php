<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminValidator;
use App\Services\AdminServices;

class ProfileSetting extends Controller
{

    public function index()
    {
        $admin = AdminServices::getAdmin();
        return view('admin.edit_admin_info',compact('admin'));
    }

    public function profileUpdate(AdminValidator $request)
    {
        return AdminServices::update($request);    
    }
    
   
}
