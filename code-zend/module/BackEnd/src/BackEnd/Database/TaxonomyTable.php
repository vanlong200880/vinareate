<?php

namespace BackEnd\Database;


use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Where;
use Zend\Stdlib\ArrayUtils;
use Zend\Db\Sql\Expression;

//use BackEnd\Database\P;
//use BackEnd\Database\DistrictTable;
//use BackEnd\Database\;

class TaxonomyTable {

    const TAXONOMY_TABLE = "taxonomy";
    const URL_RESOURCE = "/upload/";
  

    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }

    public function getAll($type = '', $col = '') {
        $select = $this->sql->select();
        $select->columns(array('*'))->from(self::TAXONOMY_TABLE);
        if ($type != '' && $sort != '')
            $select->order(array("$type $sort"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        $result->buffer();
        $result->next();
        return $resultSet;
    }
//    public function getPostbyPostImage($data) {
//        $select = $this->sql->select();
//        $select->columns(array('*'))->from(self::POST_IMG_TABLE);
//        $select->where(new \Zend\Db\Sql\Predicate\In("post_id", $data));
//        $statement = $this->sql->prepareStatementForSqlObject($select);
//        $result = $statement->execute();
//        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
//        return $resultSet;
//    }
    
//    public function DelPostbyPostID($data = '') {
//        $selectimg = $this->sql->select();
//        $selectimg->columns(array('*'));
//        $selectimg->from(self::POST_IMG_TABLE);
//        $selectimg->where(new \Zend\Db\Sql\Predicate\In("post_id", $data));
//        $statementimg = $this->sql->prepareStatementForSqlObject($selectimg);
////      echo $this->sql->getSqlStringForSqlObject($selectimg);
//        $resultimg = $statementimg->execute();
//        $resultSet = ArrayUtils::iteratorToArray($resultimg);
//        foreach ($resultSet as $item) {
//            $url = "public";
//            $url .= self::URL_RESOURCE.$item['path'].$item['name'].'.'.$item['type'];
//            try {
//                @unlink($url);
//                
//            } catch (Exception $e) {
//               $error['mess']="file not founnd";
//            }            
//        }
//        $select = $this->sql->delete();
//        $select->from(self::POST_IMG_TABLE);
//        $select->where(new \Zend\Db\Sql\Predicate\In("post_id", $data));
//        try {
//            $statement = $this->sql->prepareStatementForSqlObject($select);
//            $result = $statement->execute();
//            return true;
//            return $result = TRUE;
//        } catch (Exception $e) {
//            return $result = FALSE;
//        }
//    }

}
