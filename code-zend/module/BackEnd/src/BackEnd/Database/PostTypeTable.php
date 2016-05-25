<?php

namespace BackEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Where;
use Zend\Stdlib\ArrayUtils;
use Zend\Db\Sql\Expression;

class PostTypeTable{
    const TYPE_TABLE = "post_type";
    
        /** @var  Sql $sql */
    protected $sql;
    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll($type='',$sort='') {
              $select = $this->sql->select();
        $select->columns(array('*'))->from(self::TYPE_TABLE);
        if($type != '' && $sort != '')  $select->order(array("$type $sort"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        $result->buffer();
        $result->next();
        return $resultSet;
    }

    public function  saveData($arrayParam=''){
        $name = $arrayParam["request"]["type"];
        $description = $arrayParam["request"]["description"];
        $price = $arrayParam["request"]["price"];

        if(isset($arrayParam['id']) == true && $arrayParam['id'] != ''){
            $query=$this->sql->update(self::TYPE_TABLE);
            $query->set(array('name'=>$name,'description'=>$description,'price'=>$price));
            $query->where(array('id'=>$arrayParam['id']));            
        }
        if(isset($arrayParam["id"])==false){
        $query=$this->sql->insert();
        $query->into(self::TYPE_TABLE);
        $query->columns(array("name,description,price"));
        $query->values(array($name,$description,$price));
        }
        //$statement = $this->sql->prepareStatementForSqlObject($query);
        var_dump($this->sql->getSqlStringForSqlObject($query));
        die;
        $result = $statement->execute();
//        $resultSet = ArrayUtils::iteratorToArray($result);
        return $result;    
    }
    public function getItemById($id=''){
        $select=$this->sql->select();
        $select->from(self::TYPE_TABLE);
        $select->where(array('id'=>$id));
         $statement=$this->sql->prepareStatementForSqlObject($select);
        $result=$statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }
    public function delItemById($id=''){
        $delete=$this->sql->delete();
        $delete->from(self::TYPE_TABLE);
        $delete->where(array('id'=>$id));
        $statement=$this->sql->prepareStatementForSqlObject($delete);
        $result=$statement->execute();
        return $result;
        
    }

    
}
   
