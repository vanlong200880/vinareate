<?php
namespace FrontEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class Post{
    const POST_TABLE = "post";
    const PROVINCE_TABLE = "province";
    const WARD_TABLE = "ward";
    //    const PARENT_CATEGORY = "category";
    const CATEGORY_TABLE = "category";
    const FEATURE_TABLE = "post_features";

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
        $insert = $this->sql->insert(self::POST_TABLE);
        $insert->columns($columns)->values($values);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
//        $resultSet = ArrayUtils::iteratorToArray($result);
//        return $resultSet;
        $postId = $result->getGeneratedValue();
        return $postId;
    }

    /**
     * @param array $setColumnValue
     * @param array $where
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function update(array $setColumnValue, array $where){
        $update = $this->sql->update(self::POST_TABLE);
        $update->set($setColumnValue)->where($where);
        $statement = $this->sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        return $result;
    }

}