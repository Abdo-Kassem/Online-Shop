<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupCategory extends Model
{
    protected $fillable = ['name','category_id','image'];

    public $timestamps = false;

    protected $table = 'sub_categories';

    protected $hidden = ['category_id'];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }

    public function items(){
        return $this->hasMany('App\Models\Items','subcategory_id','id');
    }
}
