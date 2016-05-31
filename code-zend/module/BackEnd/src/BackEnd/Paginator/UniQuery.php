<?php
namespace BackEnd\Paginator;

use Illuminate\Database\Query;
use Illuminate\Database\Eloquent;
use Zend\Paginator\Adapter\AdapterInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Zend\Paginator\Adapter\DbSelect;

class UniQuery implements AdapterInterface{
    const ORDER_BY = "order_by";
    const ORDER = "order";
    const SEARCH_COLUMN = "search_column";
    const SEARCH_TERM = "search_term";

    protected $query;
    protected $options;
    protected $rowCount;

    /**
     * UniQuery constructor.
     * @param Query\Builder|Eloquent\Builder $query
     * @param array $options
     */
    public function __construct($query, $options = array()){
        /**
         * query from Eloquent\Model is Eloquent\Builder
         * which wrap Query\Builder inside
         */
        if($query instanceof Eloquent\Builder){
            $query = $query->getQuery();
        }

        $this->query = $query;

        /**
         * Default options, even when nothing from
         * $options
         */
        $this->options = array(
            self::ORDER_BY => "id",
            self::ORDER => "ASC",
            self::SEARCH_COLUMN => "name",
        );

        /**
         * Merge default & custom $options
         * override on default
         */
        foreach($options as $key => $option){
            $this->options[$key] = $option;
        }

        /**
         * Modify "query" base on $option
         */
        $this->query->orderBy($this->options["order_by"], $this->options["order"]);

        if(isset($this->options[self::SEARCH_TERM])){
            $like = '%' . $this->options[self::SEARCH_TERM] . '%';
            $this->query->where($this->options[self::SEARCH_COLUMN], "like", $like);
        }
//        $sql = $this->query->toSql();
    }

    /**
     * Returns a collection of items for a page.
     *
     * @param  int $offset Page offset
     * @param  int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage){
        $query = clone $this->query;

        $query->offset($offset)->limit($itemCountPerPage);

        return $query->get();
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count(){
        if($this->rowCount !== null){
            return $this->rowCount;
        }

//        $query = clone $this->query;

//        $subQuery = "(" . $query->toSql() . ") as T";
        $subQuery = clone $this->query;

        $countQuery = Capsule::table( Capsule::raw("({$subQuery->toSql()}) as sub") )
            ->mergeBindings($subQuery); //you need to get underlying Query Builder

//        $sql = $countQuery->toSql();
//        $countQuery = Capsule::table(Capsule::raw($subQuery))->selectRaw("count(1) as count");
//        var_dump($countQuery->toSql());
//        $numberOfRow = $countQuery->first();
//        $this->rowCount = $numberOfRow->aggregate;
        $this->rowCount = $countQuery->count();

        return $this->rowCount;
//        return $this->query->count();
    }
}