<?php

namespace App\Traits;

use PhpParser\Builder\Trait_;

Trait SaveImage 
{
   public  function saveImage($image,$path)
   {
        $imageNameAndExtention = $image->getClientOriginalName();
        $extention = $image->getClientOriginalExtension();
        $imageName = str_replace('.'.$extention,'',$imageNameAndExtention);
        $imageCurrentName = $imageName.time();
        $imageNameAndExtention = $imageCurrentName . '.' . $extention;
        $image->move($path,$imageNameAndExtention);
        return $imageNameAndExtention;
   }
}
