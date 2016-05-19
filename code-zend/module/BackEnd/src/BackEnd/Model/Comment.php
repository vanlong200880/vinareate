<?php
namespace BackEnd\Model;

class Comment extends IlluminateModel{
    protected $table = "comment";

    public function user(){
        return $this->hasOne(User::class, "id", "user_id");
    }
}