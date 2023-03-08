<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Verify extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','token'];

    protected $table = 'user_verify';

    protected $hidden = ['created_at','updated_at'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
