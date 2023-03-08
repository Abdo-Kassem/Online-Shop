<?php

namespace App\Services;

use App\Models\Phone;

class PhoneServices
{

    public function getByIDWhere($id,$column ,$value)
    {
        return Phone::select('id','wallet_approach','phone_number','is_wallet')->where($column,$value)->find($id);
    }

    
    public function updatePhone($request)
    { 
        $phone = Phone::findorfail($request->phoneID);

        $request->validate($this->walletRules($phone->id),$this->walletMessages());

        if(isset($request->walletType)){
            $phone->is_wallet = 1;
            $phone->wallet_approach = $request->walletType;
        }else{
            $phone->is_wallet = 0;
            $phone->wallet_approach = null;
        }

        $phone->phone_number = $request->phone;

        return $phone->save();
            
    }

    public function destroy($phoneID,$sellerID)
    {
        $phonesCount = Phone::where('seller_id',$sellerID)->count();

        if($phonesCount > 2 ){

            $phone = Phone::where('seller_id',$sellerID)->findorfail($phoneID);
            return $phone->delete();

        }
        
        return false;
    }

    private function walletRules($id)
    {
        return [
            'walletType'=>'in:we,vodafone,fawry,empty',
            'phone'=>"required|regex:/(01)[0-9]{9}$/|unique:phones,phone_number,".$id
        ];
    }
    private function walletMessages()
    {
        return [
            'walletType.in'=>'must be on of three specific values',
            'phone.required'=>'must enter phone number',
            'phone.regex'=>'not phone number',
            'phone.unique'=>'phone already exist'
        ];
    }


}