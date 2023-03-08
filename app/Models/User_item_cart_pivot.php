<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User_item_cart_pivot extends Model
{

    protected $fillable = ['user_id','item_id','item_count'];

    public $timestamps = false;

    protected $table = 'user_item_cart_pivot';

    protected $primaryKey = ['user_id','item_id'];

    public $incrementing = false;


    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
