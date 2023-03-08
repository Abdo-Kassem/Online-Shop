<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'id','name', 'email', 'password','acount_type','image','created_at','status','seller_verify'
    ];

    public $timestamps = false;

    protected $table = 'sellers';

    protected $hidden = [
         'remember_token','pivot',
    ]; 

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */

     public function hasVerifiedEmail()
     {
        return $this->seller_verify;
     }
   
    public function phones(){
        return $this->hasMany('App\Models\Phone','seller_id','id');
    }

    public function shops(){
        return $this->hasMany('App\Models\Shop','sellerID','id');
    }

    public function items(){
        return $this->hasMany('App\Models\Items','seller_id','id');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order','sellerID','id');
    }

    public function customers(){
        return $this->belongsToMany('App\Models\User','App\Models\Customer_Seller',
        'sellerID','userID','id','id');
    }
}
