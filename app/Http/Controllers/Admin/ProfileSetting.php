<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminValidator;
use App\Services\AdminServices;

class ProfileSetting extends Controller
{
    private $admin;

    public function __construct(AdminServices $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        $admin = $this->admin->getAdmin();
        return view('admin.edit_admin_info',compact('admin'));
    }

    public function profileUpdate(AdminValidator $request)
    {
        return $this->admin->update($request);    
    }
    
   
}
