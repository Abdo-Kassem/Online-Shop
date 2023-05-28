<?php

namespace App\Services;

use App\Basket\Basket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserServices {

    public function getByID($id, ?array $columns = null)
    {
        if($columns !== null)
            return User::select($columns)->findorfail($id);
    }

    public function getCurrent(&$userItemsCount,&$user)
    {
        $user = Auth::user();
        $userItemsCount = Basket::counts($user);

        //return orders with items of this order and data to display order like namespace and discount and new
        $orders = $user->orders()->select(['id','price','user_id','state'])->get();

        return $orders;
    }

    public function store($request)
    {
        return User::create([
            'name'=>$request->userName,
            'email'=>$request->email,
            'address' => $request->address,
            'password'=>Hash::make($request->password)
        ]);
    }

    public function update($request)
    {
        $user = Auth::user();
        $user->name = $request->userName;
        $user->email = $request->email;
        $user->address = $request->address;

        return $user->save();
    }

    public function destroy($id)
    {
        
    }

}