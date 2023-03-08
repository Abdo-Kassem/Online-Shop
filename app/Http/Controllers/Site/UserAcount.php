<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditeValidator;
use App\Services\UserServices;
use App\Traits\CalculateNewPrice;
use Illuminate\Support\Facades\Auth;

class UserAcount extends Controller
{
    use CalculateNewPrice;

    public UserServices $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
        return $this->middleware('auth');
    }

    public function index()
    { 
        $user = null;//will set by function
        $userItemsCount = 0;//will set by getCurrent function bycause by reference
        $orders = $this->userServices->getCurrent($userItemsCount,$user);

        return view('site.user_acount.userAcount',compact('orders','user','userItemsCount'));
    }

    public function edite()
    {
        $user = Auth::user();
        return view('site.user_acount.edite',compact('user'));
    }

    public function update(UserEditeValidator $request)
    {
        if(UserServices::update($request))
            return redirect()->route('user.acount')->with('success','done');
        else
            return redirect()->back()->with('fail','updation fail try again');
    }

}
