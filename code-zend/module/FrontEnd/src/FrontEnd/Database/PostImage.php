<?php
namespace FrontEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class PostImage{
    const POST_IMAGE_TABLE = "post_image";
    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter){
        $this->sql = new Sql($adapter);
    }

    /**
     * @param array $columns
     * @param array $values
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function insert(array $columns, array $values){
        $insert = $this->sql->insert(self::POST_IMAGE_TABLE);
        $insert->columns($columns)->values($values);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        $postImageId = $result->getGeneratedValue();
        return $postImageId;
    }

//    public function saveDiskAndInsert(){
//
//    }

}