<?php

namespace App\Http\Controllers\Site\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Exception;


class TestController extends Controller
{
    public function test1(){

        echo 'hello';
        $res = $this->test2();
        return $res;
    }

    public function test2(){
        $seller = Seller::first();
    
        try{
            $this->test3();
        }catch(Exception $ex){
            return $ex->getMessage();
        }finally{
            return $seller;
        }
        
       
    }
    public function test3(){
        throw new Exception('not found ');
    }
}
