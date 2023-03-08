<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','address','user_verify','is_customer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','pivot'
    ];

    
    public $timestamps = false;


    public function hasVerifiedEmail(){
        return $this->user_verify;
    }

    public function sellers()
    {
        return $this->belongsToMany('App\Models\Seller','App\Models\Customer_Seller',
            'userID','sellerID','id','id');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Models\Feedback','userID','id');
    }

    public function items(){
        return $this->belongsToMany('App\Models\Items','App\Models\User_item_cart_pivot','user_id',
            'item_id','id','id')->withPivot(['item_count']);
    }

    public function orders(){
        return $this->hasMany('App\Models\Order','user_id','id');
    }
    
    public function savedItems(){
        return $this->belongsToMany('App\Models\Items','App\Models\User_item_saved_pivot','user_id','item_id','id','id');
    }
    
}
