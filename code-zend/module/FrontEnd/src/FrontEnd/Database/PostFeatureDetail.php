<?php
namespace FrontEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class PostFeatureDetail{
    const POST_FEATURE_DETAIL_TABLE = "post_feature_detail";
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
        $insert = $this->sql->insert(self::POST_FEATURE_DETAIL_TABLE);
        $insert->columns($columns)->values($values);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        $postId = $result->getGeneratedValue();
        return $postId;
    }

}