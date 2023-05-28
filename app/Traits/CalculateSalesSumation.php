<?php

namespace App\Traits;


Trait CalculateSalesSumation
{

   //use to get category because use category name in save and retrive image from folder and folder name = cat name
   private function sellesSum(array $orders):int
   {
   
        $totalPrice = 0.0;
      
        if(count($orders) > 0){
            foreach($orders as $order){
                $totalPrice += $order->price;
            }
        }
    
        return $totalPrice;

  }

}
