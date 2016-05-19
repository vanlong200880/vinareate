<?php
namespace BackEnd\Model;

use Illuminate\Database\Eloquent\Model;

class IlluminateModel extends Model{
    /**
     * if we has added timestamps column (created_at, updated_at)
     * in table > insert will automatically add now()
     * if not > exception pdo, insert into non-exist columns
     *
     * make by default, $timestamps is true
     * change it to false
     * @var bool
     */
    public $timestamps = false;
}