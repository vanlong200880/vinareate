<?php

namespace BackEnd\Database;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;

class PostTable {

    const POST_TABLE = "post";

    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll($type = '', $col = '') {
        $select = $this->sql->select();
        $select->columns(array('*'))->from(self::POST_TABLE);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        $result->buffer();
        $result->next();
        return $resultSet;
    }

    public function getPostbyCategory($id) {
        $select = $this->sql->select();
        $select->columns(array('id'))->from(self::POST_TABLE);
        $select->where(array('category_id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    public function DelPostbyCategoryId($id) {
        $del = $this->sql->delete();
        $del->from(self::POST_TABLE);
        $del->where(array('category_id'=>$id));
        $statement = $this->sql->prepareStatementForSqlObject($del);
        
        try {
            $result = $statement->execute(); 
            return $result=TRUE;
        } catch (Exception $exc) {
           return $result=FALSE;
        }

        if(is_array($resultSet)) return true;
        else return FALSE;
        
    }

}
