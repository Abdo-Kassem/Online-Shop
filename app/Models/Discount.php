<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['discount_value','item_id','time_start','time_end'];

    public $timestamps = false;

    protected $table = 'discount';

    public function item(){
        return $this->belongsTo('App\Models\Items','item_id','id');
    }
}
