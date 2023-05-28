<?php

namespace App\Services;

use App\interfaces\StaticServicesContract;
use App\Models\Feedback;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackServices{

    public function store(Request $request,$userID)
    {
        $validated = $this->validate($request);

        $res = Feedback::create([
            'itemID'=>$validated['itemID'],'userID'=>$userID,'feedback'=>$validated['feedbackNumber']
        ]);

        if($res){
            return response()->json([
                'state'=>true,
                'message'=>'done'
            ]);
            
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'not create'
            ]);
        }
    }

    private function validate(Request $request)
    {
        return $request->validate(
            ['feedbackNumber'=>'required|digits_between:1,5','itemID'=>'required|numeric'],
            ['feedbackNumber.digits_between'=>'must between 1 and5']
        );
    }
    
}