<?php
namespace BackEnd\Model;
class Province extends IlluminateModel{
    protected $table = "province";

    public function district(){
        return $this->hasMany(District::class, "provinceid", "provinceid");
    }

    public function troll(){
        return $this->hasMany(District::class, "provinceid", "provinceid");
    }
}