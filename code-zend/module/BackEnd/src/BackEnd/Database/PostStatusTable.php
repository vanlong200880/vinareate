<?php

namespace BackEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Where;
use Zend\Stdlib\ArrayUtils;
use Zend\Db\Sql\Expression;

class PostStatusTable{
    const STATUS_TABLE = "post_status";
    
        /** @var  Sql $sql */
    protected $sql;
    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll($type='',$sort='') {
              $select = $this->sql->select();
        $select->columns(array('*'))->from(self::STATUS_TABLE);
        if($type != '' && $sort != '')  $select->order(array("$type $sort"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        $result->buffer();
        $result->next();
        return $resultSet;
    }

    public function  saveData($arrayParam=''){
        $name = $arrayParam["request"]["namestatus"];
        if(isset($arrayParam['id']) == true && $arrayParam['id'] != ''){
            $query=$this->sql->update(self::STATUS_TABLE);
            $query->set(array('name'=>$name));
            $query->where(array('id'=>$arrayParam['id']));            
        }
        if(isset($arrayParam["id"])==false){
        $query=$this->sql->insert();
        $query->into(self::STATUS_TABLE);
        $query->columns(array("name"));
        $query->values(array($name));
        }
        $statement = $this->sql->prepareStatementForSqlObject($query);
        $result = $statement->execute();
//        $resultSet = ArrayUtils::iteratorToArray($result);
        return $result;    
    }
    public function getItemById($id=''){
        $select=$this->sql->select();
        $select->from(self::STATUS_TABLE);
        $select->where(array('id'=>$id));
         $statement=$this->sql->prepareStatementForSqlObject($select);
        $result=$statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }
    public function delItemById($id=''){
        $delete=$this->sql->delete();
        $delete->from(self::STATUS_TABLE);
        $delete->where(array('id'=>$id));
        $statement=$this->sql->prepareStatementForSqlObject($delete);
        $result=$statement->execute();
        return $result;
        
    }

    
}
   
