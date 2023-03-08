<?php

namespace App\interfaces;

interface StaticServicesContract{

    public static function all();

    public static function getByID($id,array $columns = null);

    public static function store($data);

    public static function update($data);

    public static function destroy($id);

}