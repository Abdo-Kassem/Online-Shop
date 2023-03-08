<?php

namespace App\Services;

use App\interfaces\StaticServicesContract;
use App\Models\Feedback;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackServices{

    public static function all()
    {
        
    }

    public static function getByID($id, ?array $columns = null)
    {
        
    }

    /**
     * return item that satisfy condition 
     * 
     */
    public static function getItemsWhere(Feedback $feedback,$column,$value,array $columns = null):?Items
    {
        if($columns !== null)//use first because one feedback of one item
            return $feedback->item()->where($column,$value)->select($columns)->first();
        return $feedback->item()->where($column,$value)->first();
    }

    public static function getLastFeedback($sellerID){

        $lastFeedback = Feedback::with(['item'=>function($q)use($sellerID){
            return $q->where('seller_id',$sellerID)->select('items.id','name');
        }])->orderBy('created_at','DESC')->first();
        
        if($lastFeedback !== null){
            $lastFeedback->customer = UserServices::getByID($lastFeedback->userID,['name'])->name;
            $lastFeedback->makeHidden(['itemID','userID','created_at']);
            return $lastFeedback;
        }
        return null;

    }

    public static function store(Request $request,$userID)
    {
        $validated = static::validate($request);

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

    private static function validate(Request $request)
    {
        return $request->validate(
            ['feedbackNumber'=>'required|digits_between:1,5','itemID'=>'required|numeric'],
            ['feedbackNumber.digits_between'=>'must between 1 and5']
        );
    }

    public static function update($data)
    {
        
    }

    public static function destroy($id)
    {
        
    }
    
}