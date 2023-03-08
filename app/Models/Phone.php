<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Phone extends Model
{
    protected $fillable = ['phone_number','seller_id','is_wallet','wallet_approach'];
    protected  $table = 'phones';
    public $timestamps = false;

    public function  seller(){
        return $this->belongsTo('App\Models\Phone','seller_id','id');
    }
}
