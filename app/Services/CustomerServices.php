<?php

namespace App\Services;

use App\Models\Seller;
use App\Models\User;
use App\Traits\RemoveImage;

class CustomerServices {

    use RemoveImage;

    public static function getCustomerFeedback(Seller $seller)
    {
        $users = SellerServices::getCustomer($seller,['name as userName','id']); 

        foreach($users as $user){
           
            $user->feedbacks =$user->feedbacks()->get(); 

            foreach($user->feedbacks as $feedback){
                $feedback->itemName = FeedbackServices::getItemsWhere(
                    $feedback,'seller_id',$seller->id,['name']
                )->name;
            }
    
            $user->feedbacks->makeHidden(['itemID','customerID','created_at']);
        }
        
        return $users;
    }

    public static function destroy($customerID,$sellerID)//'site/images/profile/'
    {
        $customer = User::select('id')->findorfail($customerID);

        return $customer->sellers()->detach($sellerID);
       
    }

    public static function setUserAsCustomer(User $user)
    {
        if($user->is_customer == 0){
            $user->is_customer = 1;
            $user->save();
        }
    }

    public static function addUserToSeller(User $user,$sellerID)
    {
        $res = $user->sellers()->where('sellerID',$sellerID)->first();
        if($res === null){
            $user->sellers()->attach($sellerID);
        }
    }

}