<?php
namespace BackEnd\Database;

use Exception;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class PostFeature{
    const POST_FEATURES_TABLE = "post_features";
    /** @var  Sql $sql */
    protected $sql;
    protected $storage;

    public function __construct($adapter){
        $this->sql = new Sql($adapter);
    }

    /**
     * @param array $postParams
     * @return mixed|null
     */
    public function insert(array $postParams){
        $postParams = $this->verifyInsertParams($postParams);
        $insert = $this->sql->insert(self::POST_FEATURES_TABLE);
        $insert->columns(array_keys($postParams))->values(array_values($postParams));
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        //get id from last row inserted
        $postContactId = $result->getGeneratedValue();
        return $postContactId;
    }

    public function all(){
        $select = $this->sql->select();
        $select->columns(array("*"))->from(self::POST_FEATURES_TABLE);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    /**
     * @param string $id
     * @return object $singleItem
     */
    public function get($id){
        $select = $this->sql->select();
        $select->columns(array("*"))->from(self::POST_FEATURES_TABLE)->where(array("id" => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        $singleItem = $resultSet[0];
        return $singleItem;
        //        return $result;
    }


    /**
     * @param array $setColumnValue
     * @param array $where
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function update(array $setColumnValue, array $where){
        $setColumnValue = $this->verifyInsertParams($setColumnValue);
        $update = $this->sql->update(self::POST_FEATURES_TABLE);
        $update->set($setColumnValue)->where($where);
        $statement = $this->sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        return $result;
    }


    /**
     * @param $id
     * @return bool|\Zend\Db\Adapter\Driver\ResultInterface
     */
    public function delete($id){
        $shouldDelete = $this->verifyDeleteParams($id);
        $result = true;
        if($shouldDelete){
            $delete = $this->sql->delete();
            $delete->from(self::POST_FEATURES_TABLE)->where(array("id" => $id));
            /**
             * handle when foreign key exist ????
             * post --- feture, can not delete if they are mapped
             */
            $statement = $this->sql->prepareStatementForSqlObject($delete);

            try{
                $statement->execute();
                $result = true;
            }catch(Exception $e){
                $result = false;
            }
        }
        if(!$shouldDelete){
            $result = false;
        }
        return $result;
    }

    /**
     * when we show input for user edit
     * input is TEXT, but value in database may different
     * >>> mismatch >>> NULL / 0
     * how to check this ????
     * @param $postParams
     * @return mixed
     */
    public function verifyInsertParams($postParams){
        if(isset($postParams["action"])){
            unset($postParams["action"]);
        }
        if(empty($postParams["parent"])){
            //by remove "parent" from $postParams
            //we not insert "parent" when not exist
            //"parent" map NULL
            unset($postParams["parent"]);
        }
        return $postParams;
    }

    public function getChildren($parentId){
        $select = $this->sql->select();
        $select->columns(array("*"))->from(self::POST_FEATURES_TABLE)->where(array("parent" => $parentId));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $resultSet = ArrayUtils::iteratorToArray($result);
        return $resultSet;
    }

    public function verifyDeleteParams($id){
        $shouldDelete = true;
        //        $postFeature = $this->get($id);
        //        if(!$postFeature["parent"]){
        //            $shouldDelete = false;
        //        }
        //        if()
        $children = $this->getChildren($id);
        if(count($children) > 0){
            $shouldDelete = false;
        }
        return $shouldDelete;
    }

    /**
     * @param string $itemId
     * @return array $deletedIds
     */
    public function deepDelete($itemId){
        $deletedIds = array();
        $this->recursiveDelete($itemId, $deletedIds);
        return $deletedIds;
    }

    private function recursiveDelete($itemId, $deletedIds){
        $children = $this->getChildren($itemId);
        //delete this item, right after has there children
        //        $this->delete($itemId);
        if(count($children) === 0){
            //this $itemId has no children
            //1. delete him, bcs delete now is allowed
            //only foreign on post--feature is prevented
            if($this->delete($itemId)){
                //store id when success delete
                $deletedIds[] = $itemId;
            }
        }
        if(count($children) > 0){
            foreach($children as $child){
                //recursive call
                $this->recursiveDelete($child["id"], $deletedIds);
            }
        }
    }


}