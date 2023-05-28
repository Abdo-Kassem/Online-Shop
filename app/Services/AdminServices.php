<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminServices {

    public function update($request)
    {
        $admin = $this->getAdmin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if(Hash::check($request->old_password,$admin->password)){
            
            if($request->new_password != null){
                $admin->password = Hash::make($request->new_password);
                $res = $admin->save();
                if($res){
                    Auth::guard('admin')->login($admin);
                    return redirect()->route('admin.home');
                }
                else
                    return redirect()->back()->with('fail','update fail try again');
            }

            $res = $admin->save();

            if($res){
                return redirect()->route('admin.home');
            }else
                return redirect()->back()->with('fail','update fail try again');

        }
        else
        {
            return redirect()->back()->with('fail','old password wrong');
        }
    }
  
    public function getAdmin(){
        return Admin::first();
    }

}