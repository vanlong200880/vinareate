<?php

namespace BackEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;

class WardTable{

    const WARD_TABLE = "ward2";
    const DISTRICT_TABLE = "district2";
    const PROVINCE_TABLE = "province2";

    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll() {
        $select = $this->sql->select();

        $select->columns(array(
            "id",
            "name",
            "district_id"
        ))->from(self::WARD_TABLE);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result;
    }

    public function saveData($arrayParam = '', $name = '') {

        $value1 = $arrayParam["request"]["nameward"];
        $type = $arrayParam["request"]["slecttype"];
        if (isset($arrayParam['id']) == true && $arrayParam['id'] != '') {
            $query = $this->sql->update(self::WARD_TABLE);
            $query->set(array('name' => $value1));
            $query->where(array('id' => $arrayParam['id']));
        }
        if (isset($arrayParam["id"]) == false) {
            $query = $this->sql->insert();
            $query->into(self::WARD_TABLE);
            $query->columns(array("name", "type"));
            $query->values(array($value1, $type));
        }
        $statement = $this->sql->prepareStatementForSqlObject($query);
        $result = $statement->execute();
//        $resultSet = ArrayUtils::iteratorToArray($result);
        return $result;
    }

    public function getItemById($id) {
        $select = $this->sql->select();
        $select->columns(array(
            "id",
            "name",
            "type",
        ))->from(self::WARD_TABLE);
        $select->where(array('id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        if (is_numeric($id)) {
            return $result->current();
        } else {
            return $result;
        }
    }

    public function getCategory() {
        $select = $this->sql->select();
        $select->columns(array(
            "id",
            "name",
            "type",
        ))->from(self::PROVINCE_TABLE);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    public function delItemFromId($id) {
        $del = $this->sql->delete();
        $del->from(self::WARD_TABLE);
        $del->where(array('id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($del);
        $result = $statement->execute();
        return $result;
    }
    public function getListDistrict($provinceId=''){
        $select=$this->sql->select();
        $select->columns(array(
            "id",
            "name",
            "type",
            "province_id"
        ))->from(self::DISTRICT_TABLE);
                $select->where(array("province_id"=>$provinceId));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

}
