<?php
namespace FrontEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class PlaceQuery{
    const DISTRICT_TABLE = "district";
    const PROVINCE_TABLE = "province";
    const WARD_TABLE = "ward";

    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter){
        $this->sql = new Sql($adapter);
    }


    public function getProvinces(){
        $select = $this->sql->select();
        $select->columns(array("name"))->from(self::PROVINCE_TABLE);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }
}