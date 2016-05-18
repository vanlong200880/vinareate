<?php
namespace BackEnd\Model;

use Illuminate\Database\Eloquent\Model;

class PostFeatureDetail extends Model{
    protected $table = "post_feature_detail";

    public function feature(){
        return $this->hasOne(PostFeature::class, "id", "post_features_id");
    }
}