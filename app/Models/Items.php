<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $fillable = ['name','details','image','price','subcategory_id','seller_id','item_number','shipping_cost'];
   

    public $timestamps = false;

    protected $table = 'items';

    protected $hidden = ['pivot'];

    public function supCategory(){
        return $this->belongsTo('App\Models\SupCategory','subcategory_id','id');
    }

    public function discount(){
        return $this->hasOne('App\Models\Discount','item_id','id');
    }

    public function ads(){
        return $this->hasOne('App\Models\Ads','item_id','id');
    }

    public function users(){
        return $this->belongsToMany('App\Models\User','App\Models\User_item_cart_pivot',
            'item_id','user_id','id','id')->withPivot(['item_count']);
    }

    public function orders(){
        return $this->belongsToMany('App\Models\Order','Order_Items_Pivot','item_id','order_id','id','id')
            ->withPivot('item_count');
    }

    public function userSaving(){
        return $this->belongsToMany('App\Models\User','App\Models\User_item_saved_pivot','item_id','user_id','id','id');
    }
    public function sellers(){
        return $this->belongsTo('App\Models\Seller','seller_id','id');
    }

    public function feedbacks(){
        return $this->hasMany('App\Models\Feedback','itemID','id');
    }
}
