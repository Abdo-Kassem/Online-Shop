<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
            'name','address','post_number','category_id','city','sended_person_email','sellerID','created_at'
    ];
    protected $table='shops';
    public $timestamps = false;

    public function seller(){
        return $this->belongsTo('App\Models\Seller','sellerID','id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
}
