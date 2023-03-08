<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','selling_cost','image'];

    public $timestamps = false;

    protected $table = 'categories';

    public function supCategories(){
        return $this->hasMany('App\Models\SupCategory','category_id','id');
    }

}
