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

class PostImageTable{
    const POST_IMG_TABLE="post_image";
    const POST_TABLE="post";
//    const POST_POST_IMAGE_TABLE="post_image";
//    const POST_TAX_HISTORY_TABLE="post_tax_history";
//    const POST_CONTACT_TABLE="post_contact";
//    const POST_FEUTURE_DETAILL_TABLE="post_feuture_detall";
//    const COMMENT_TABLE="comment";
//    const RATING_TABLE="rating";
//    
    

    /** @var  Sql $sql */
    protected $sql;

    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
    }
//     public function getAll($type='',$col='') {
//        $select = $this->sql->select();
//        $select->columns(array('*'))->from(self::POST_IMG_TABLE);
////        if($type != '' && $sort != '')  $select->order(array("$type $sort"));
//        $statement = $this->sql->prepareStatementForSqlObject($select);
//        $result = $statement->execute();
//        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
//        $result->buffer();
//        $result->next();
//        return $resultSet;
//     }
     public function getPostbyPostImage($data) {
         $select=$this->sql->select();
         $select->columns(array('*'))->from(self::POST_IMG_TABLE);
         $select->where(new \Zend\Db\Sql\Predicate\In("post_id", $data));
         $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        return $resultSet;
     }
     public function DelPostbyPostImage($data) {
         $select=$this->sql->delete();
         $select->from(self::POST_IMG_TABLE);
         $select->where(new \Zend\Db\Sql\Predicate\In("post_id", $data));
         $statement = $this->sql->prepareStatementForSqlObject($select);
//         var_dump($statement);
        $result = $statement->execute();
//        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        return true;
     }
}

