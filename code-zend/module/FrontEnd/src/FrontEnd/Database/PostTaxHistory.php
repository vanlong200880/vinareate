<?php
namespace FrontEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class PostTaxHistory{
    const POST_TAX_HISTORY_TABLE = "post_tax_history";
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
        $insert = $this->sql->insert(self::POST_TAX_HISTORY_TABLE);
        $insert->columns($columns)->values($values);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        $postId = $result->getGeneratedValue();
        return $postId;
    }

}