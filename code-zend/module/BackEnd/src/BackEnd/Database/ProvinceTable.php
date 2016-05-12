<?php

namespace BackEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class ProvinceTable{
    const PROVINCE_TABLE = "province";
        /** @var  Sql $sql */
    protected $sql;
    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll() {
            $select = $this->sql->select();
            $select->columns(array('*'))->from(self::PROVINCE_TABLE);
            $statement = $this->sql->prepareStatementForSqlObject($select);
            $redult = $statement->execute();
            $resultSet = ArrayUtils::iteratorToArray($redult);
            return $resultSet;
    }
    public function getProvinces(){
        $select = $this->sql->select();
        $select->columns(array(
            "provinceid",
            "name",
        ))->from(self::PROVINCE_TABLE);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }
    public function  saveData($arrayParam=''){
    
        $value1 = $arrayParam["request"]["namecity"];
        $value1=ucwords($value1);
        if(isset($arrayParam['id']) == true && $arrayParam['id'] != ''){
            $query=$this->sql->update(self::PROVINCE_TABLE);
            $query->set(array('name'=>$value1));
            $query->where(array('id'=>$arrayParam['id']));
            
        }
        if(isset($arrayParam["id"])==false){
        $query=$this->sql->insert();
        $query->into(self::PROVINCE_TABLE);
        $query->columns(array("name"));
        $query->values(array($value1));
        }
        $statement = $this->sql->prepareStatementForSqlObject($query);
        $result = $statement->execute();
//        $resultSet = ArrayUtils::iteratorToArray($result);
       
        return $result;    
    }
    public function delItemFromId($id) {
        $del=$this->sql->delete();
            $del->from(self::PROVINCE_TABLE);
            $del->where(array('id'=>$id));
        $statement=$this->sql->prepareStatementForSqlObject($del);
        $result =$statement->execute();
        return $result;
    }
    public function  getItemById($id){
        $select=$this->sql->select();
        $select->columns(array(
            "id",
            "name",
        ))->from(self::PROVINCE_TABLE);
        $select->where(array('id'=>$id));
         $statement=$this->sql->prepareStatementForSqlObject($select);
        $result =$statement->execute();
        if(is_numeric($id)){
            return $result->current();
        }
        else{
        return $result;
        }
    }

}
