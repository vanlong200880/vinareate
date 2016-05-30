<?php
namespace BackEnd\Paginator;

use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;

class UniSelect extends DbSelect{
//    protected $options;

    public function __construct(Select $select, $adapterOrSqlObject, ResultSetInterface $resultSetPrototype = null,
        Select $countSelect = null){
        parent::__construct($select, $adapterOrSqlObject, $resultSetPrototype, $countSelect);
//        $this->options = $options;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  int $offset Page offset
     * @param  int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage){
        $select = clone $this->select;
        $select->offset($offset);
        $select->limit($itemCountPerPage);

//        $order = $this->options["order_by"] . " " . $this->options["order"];
//        $select->order($order);

//        if(isset($this->options["search_term"])){
//            $column = (isset($this->options["search_column"]))? $this->options["search_column"] : "name";
//            $like = "%" . $this->options["search_term"] . "%";
//            $select->where(new Like($column, $like));
//        }

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        $resultSet = clone $this->resultSetPrototype;
        $resultSet->initialize($result);

        return iterator_to_array($resultSet);
    }

}