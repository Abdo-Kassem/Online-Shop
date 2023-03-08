<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['price','user_id','sellerID','state','created_at','send_time']; ///state say do order send be seller or not


    public $timestamps = false;

    protected $table = 'orders';

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function items(){
        return $this->belongsToMany('App\Models\Items','Order_Items_Pivot','order_id','item_id','id','id')
        ->withPivot('item_count');
    }
    public function seller(){
        return $this->belongsTo('App\Models\Seller','sellerID','id');
    }
}
