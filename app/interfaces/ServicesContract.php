<?php

namespace App\interfaces;

interface ServicesContract{

    public function all();

    public function store($request);

    public function update($request);

    public function destroy($id);

    public function getByID($id);

}