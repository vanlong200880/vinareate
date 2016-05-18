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

class CategoryTable{
    const CATEGORY_TABLE="category";
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
    protected $adapter;

    public function __construct($adapter) {
        $this->sql = new Sql($adapter);
        $this->adapter = $adapter;
    }
     public function getAll($type='',$col='') {
        $select = $this->sql->select();
        $select->columns(array('*'))->from(self::CATEGORY_TABLE);
//        if($type != '' && $sort != '')  $select->order(array("$type $sort"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        var_dump($result);
        $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
        $result->buffer();
        $result->next();
        return $resultSet;
     }
     public function getPostAndDelAll($id=''){
//         $select=$this->sql->select();
//         $select->columns(array('id'));
//         $select->from(self::POST_TABLE);
//         $select->where(array('category_id'=>$id));
//         $statement=$this->sql->prepareStatementForSqlObject($select);
//         $result=$statement->execute();
//         $resultSet = \Zend\Stdlib\ArrayUtils::iteratorToArray($result);
//         
            //table post
         $post=new PostTable($this->adapter);
         $selectpost=$post->getPostbyCategory($id);
         //table post_image
         $postimg=new PostImageTable($this->adapter);
         //tabel post_tax_history
         $posttax=new PostTaxHistoryTable($this->adapter);
         //table post_contact
         $postcontact=new PostContactTable($this->adapter);
         //table post_feature_detailt
         $postfeature=new PostFeatureDetailTable($this->adapter);
         //table comment table
         $postcomment=new PostCommentTable($this->adapter);
         //table rating table
         $postrating=new PostRatingTable($this->adapter);
         
         $data=array();
         foreach ($selectpost as $value){
             $data[] = $value["id"];
         }
         $delpostimg=$postimg->DelPostbyPostImage($data);
         $delpostTax=$posttax->DelPostTaxbyPostID($data);
         $delpostcontact=$postcontact->DelContactbyPostId($data);
         $delpostfeaturedetail=$postfeature->DelFeatureDetailbyPostId($data);
         $delpostcomment=$postcomment->DelCommentbyPostId($data);
         $delpostrating=$postrating->DelRatingbyPostId($data);

         if($delpostTax == true && $delpostimg == true && $delpostcontact == true && $delpostfeaturedetail == true && $delpostcomment==true && $delpostrating==true){
             $delpost=$post->DelPostbyCategoryId($id);
             
         }
         if($delpost==true) echo "success";
         die();
         
//         var_dump($listpostTax);
//         var_dump($listpostimg);
//         die();
//         $listpost=$posttax->
//         echo "<pre>";
//         $dataValues = array_values($data);
//         print_r($selectpost);
//         var_dump("data", $data);
//         foreach($selectpost as $value){
//             $data['post_id']=$value['id'];
//         $listpostimg=$postimg->DelPostbyPostImage($data);
             
            
//         }
         
//         echo "<pre>";
//         print_r($postimg->getPostbyPostImage($id));
//         if(is_array($resultSet)){            
////             delete image by post_id
//             $postimg=$this->sql->delete();          
//            foreach ($resultSet as $key => $value) {
//            }
////            $delpost=$this->sql->delete();
////            $delpost->from(self::POST_TABLE);
////            $delpost->where(array('id'=>$id));
////            $delcuoi=$this->sql->prepareStatementForSqlObject($delpost);
////            $delcuoi->execute();
//           
//         }
//         echo "<pre>";
//         print_r($resultSet);   
     }
}

