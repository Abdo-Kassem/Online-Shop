<?php

namespace App\Traits;

use App\Exceptions\FileNotFound;

Trait RemoveImage 
{
   /**
    * @param path = file name and path or path if you want delete directory
    * @return bool
    */
   public static function RemoveImage($path)
   {
      if(is_file($path) || is_dir($path)){
         return unlink($path);
      }else{
         throw new FileNotFound('not image exist or not directory');
      }    
   }
}
