<?php
namespace FrontEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class HousePosition{
    const DISTRICT_TABLE = "district";
    const PROVINCE_TABLE = "province";
    const WARD_TABLE = "ward";
//    const PARENT_CATEGORY = "category";
    const CATEGORY_TABLE = "category";

    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter){
        $this->sql = new Sql($adapter);
    }

    /**
     * @return array
     */
    public function getProvinces(){
        $select = $this->sql->select();
        $select->columns(array(
            "provinceid",
            "name",
            "type"
        ))->from(self::PROVINCE_TABLE);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    /**
     * @param string $provinceId
     * @return array;
     */
    public function getDistrictOnProvinceId($provinceId){
        $select = $this->sql->select();
        $select->columns(array(
            "districtid",
            "name",
            "type"
        ))->from(self::DISTRICT_TABLE)->where(array("provinceid" => $provinceId));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    public function getWardOnDistrictId($districtid){
        $select = $this->sql->select();
        $select->columns(array(
            "wardid",
            "name",
            "type"
        ))->from(self::WARD_TABLE)->where(array("districtid" => $districtid));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    public function getParentCategory(){
        $select = $this->sql->select();
        $select->columns(array(
            "id",
            "name"
        ))->from(self::CATEGORY_TABLE)->where(array("parent" => null));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    public function getCategory($parentId){
        $select = $this->sql->select();
        $select->columns(array(
            "id",
            "name",
        ))->from(self::CATEGORY_TABLE)->where(array("parent" => $parentId));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }
}