<?php
namespace BackEnd\Model;

class PostFeature extends IlluminateModel{
    protected $table = "post_features";

    public function feature(){
        return $this->hasMany(PostFeature::class, "parent", "id");
    }
}