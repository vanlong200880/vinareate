<?php
namespace BackEnd\Model;

class PostFeatureDetail extends IlluminateModel{
    protected $table = "post_feature_detail";

    public function feature(){
        return $this->hasMany(PostFeature::class, "id", "post_features_id");
    }

    public function featureX(){
        return $this->feature()
            ->selectRaw('count(1) as aggregate');
    }
}