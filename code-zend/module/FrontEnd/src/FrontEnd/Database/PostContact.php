<?php
namespace FrontEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class PostContact{
    const POST_CONTACT_TABLE = "post_contact";
    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter){
        $this->sql = new Sql($adapter);
    }

    /**
     * @param array $columns
     * @param array $values
     * @return mixed|null
     */
    public function insert(array $columns, array $values){
        $insert = $this->sql->insert(self::POST_CONTACT_TABLE);
        $insert->columns($columns)->values($values);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        //get id from last row inserted
        $postContactId = $result->getGeneratedValue();
        return $postContactId;
    }

}