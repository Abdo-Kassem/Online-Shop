<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\FeedbackServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackManager extends Controller
{
    public function setFeedback(Request $request)
    {
        $userID = Auth::user()->id;
        
        return FeedbackServices::store($request,$userID);
        /*if($res)
            return response()->json(['success'=>'success']);
        return response()->json(['fail'=>'add feedback fail']);*/
    }
}
