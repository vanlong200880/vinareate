<?php
namespace BackEnd\Model;

class PostImage extends IlluminateModel{
    protected $table = "post_image";

    protected $fillable = array(
        "name",
        "type",
        "size",
        "path",
        "post_id"
    );
}