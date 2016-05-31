<?php
namespace BackEnd\Model;

class Category extends IlluminateModel{
    protected $table = "category";

    public function category(){
        return $this->hasMany(Category::class, "parent", "id");
    }
}