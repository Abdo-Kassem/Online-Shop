<?php

namespace App\Services;

use App\Models\Seller;
use App\Models\User;
use App\Traits\RemoveImage;
use Illuminate\Support\Facades\Auth;

class CustomerServices {

    use RemoveImage;

    public function getCustomerFeedback(Seller $seller)
    {
        $users = $seller->customers()->select(['name as userName','id'])->paginate(PAGINATION); 

        foreach($users as $user){
           
            $user->feedbacks =$user->feedbacks()->get(); 

            foreach($user->feedbacks as $feedback){
                
                $feedback->itemName = $feedback->item()->select('name')->where('seller_id',$seller->sellerID);
              
            }
    
            $user->feedbacks->makeHidden(['itemID','customerID','created_at']);
        }
        
        return $users;
    }

    public function destroy($customerID,$sellerID)//'site/images/profile/'
    {
        $customer = User::select('id')->findorfail($customerID);

        return $customer->sellers()->detach($sellerID);
       
    }

    public function setUserAsCustomer(User $user)
    {
        if($user->is_customer == 0){
            $user->is_customer = 1;
            $user->save();
        }
    }

    public function addUserToSeller(User $user,$sellerID)
    {
        $res = $user->sellers()->where('sellerID',$sellerID)->first();
        if($res === null){
            $user->sellers()->attach($sellerID);
        }
    }

    public function getCustomer(Seller $seller)
    {
        return $seller->customers()->select(['name as customerName'])->paginate(PAGINATION);
    }

}