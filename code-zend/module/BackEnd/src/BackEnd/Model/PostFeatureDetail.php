<?php
namespace BackEnd\Model;

class PostFeatureDetail extends IlluminateModel{
    protected $table = "post_feature_detail";

    public function feature(){
        return $this->hasOne(PostFeature::class, "id", "post_features_id");
    }
}