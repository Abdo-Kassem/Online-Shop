<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_item_saved_pivot extends Model
{
    protected $fillable = ['user_id','item_id'];
    public $timestamps = false;
    protected $table = 'users_items_saved_pivot';
}
