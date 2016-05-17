<?php

namespace BackEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;

class DistrictTable{

    const DISTRICT_TABLE = "district";
    const PROVINCE_TABLE = "province";

    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll($type='',$sort='') {
        $select = $this->sql->select();
        $select->columns(array('*'))->from(self::DISTRICT_TABLE);
        if($type != '' && $sort != '')  $select->order(array("$type $sort"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        $result->buffer();
        $result->next();
        return $resultSet;
    }

    public function saveData($arrayParam = '', $name = '') {

        $value1 = $arrayParam["request"]["namedistrict"];
        $type = $arrayParam["request"]["slecttype"];
        $idprovince=$arrayParam["request"]["select_province"];

        if (isset($arrayParam['id']) == true && $arrayParam['id'] != '') {
            $query = $this->sql->update(self::DISTRICT_TABLE);
            $query->set(array('name' => $value1, 'province_id'=>$idprovince,'type'=>$type));
            $query->where(array('id' => $arrayParam['id']));
        }
        if (isset($arrayParam["id"]) == false) {
            $query = $this->sql->insert();
            $query->into(self::DISTRICT_TABLE);
            $query->columns(array("name", "type", "province_id"));
            $query->values(array($name, $type, $idprovince));
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
            "province_id",
        ))->from(self::DISTRICT_TABLE);
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
        $del->from(self::DISTRICT_TABLE);
        $del->where(array('id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($del);
        $result = $statement->execute();
        return $result;
    }

}
