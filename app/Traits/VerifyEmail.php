<?php

namespace App\Traits;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

trait verifyEmail {

    /**
     * //create token and then stor person verify  row and return token
     * @param string table name
     * @param string column name
     * @param string column value
     */
    public function createPersonVerify($table,$key,$value)
    {
        $token = $this->createToken();
        DB::table($table)->insert([
            $key => $value,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return $token;
    }

    public function createToken()
    {
        return Str::random(60);
    }

}