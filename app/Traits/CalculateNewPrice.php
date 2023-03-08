<?php

namespace App\Traits;

Trait CalculateNewPrice 
{

   //use to get category because use category name in save and retrive image from folder and folder name = cat name
   public static function calcNewPrice($discount,$price){
      $discount = str_replace('%','',$discount);
      $discountValue = $price-($price * $discount) / 100;
      return $discountValue;   
   }
}
