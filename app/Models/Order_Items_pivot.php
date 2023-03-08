<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Items_pivot extends Model
{
    
    protected $fillable = ['order_id','item_id','item_count'];

    protected $table = 'order_items_pivot';

    public $timestamps = false;


}
