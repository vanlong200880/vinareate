<?php

namespace BackEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Stdlib\ArrayUtils;
use Zend\Db\Sql\Expression;

class ProvinceTable{
    const PROVINCE_TABLE = "province";
    const DISTRICT_TABLE = "district";
    const WARD_TABLE = "ward";
        /** @var  Sql $sql */
    protected $sql;
    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll() {
            $select = $this->sql->select();
            $select->columns(array('*'));
        $select->from(self::PROVINCE_TABLE);
//                $select->join('district', 'province.id = district.province_id');
                $statement = $this->sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            $resultSet = ArrayUtils::iteratorToArray($result);
            $result->buffer();
            $result->next();
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
    public function  getItemById($id=''){
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
    public function getDistrictbyProvinceID($province_id='', $type='',$sort=''){
         $select = $this->sql->select();
                if($province_id){
                $select->columns(array('id'));
                $select->from(self::PROVINCE_TABLE);
                $select->join(self::DISTRICT_TABLE, 'province.id = district.province_id', array('name'));
                $select->order($type,$sort);
                $select->where(array('province.id'=>$province_id));
                }else{
                $select->columns(array('*'));
                $select->from(self::PROVINCE_TABLE);
                $select->join(self::DISTRICT_TABLE, 'province.id = district.province_id', array('count'=>new Expression('COUNT(district.name)')),'left');
                $select->group(array('province.id'));
//                var_dump($type);
//                var_dump($sort);
                if($type != '' && $sort != '')  $select->order(array("$type $sort"));
                }
                $statement = $this->sql->prepareStatementForSqlObject($select);
             
            $result = $statement->execute();
            $resultSet = ArrayUtils::iteratorToArray($result);
            $result->buffer();
            return $resultSet;
    }
     public function ListAllChild($id){
        $select=$this->sql->select();
        $select->columns(array('*'));
        $select->from(self::PROVINCE_TABLE);
        $select->join(self::DISTRICT_TABLE, 'province.id = district.province_id', array('district_name'=>'name'),'left');
        $select->join(self::WARD_TABLE, 'province.id = ward.province_id', array('ward_name'=>'name'),'inner');
        $select->where(array('province.id'=>$id));
        $statement=$this->sql->prepareStatementForSqlObject($select);
        $result=$statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }
}
   
