<?php
namespace BackEnd\Controller;

use BackEnd\Model\PostFeature;
use BackEnd\Paginator\UniQuery;
use Zend\Db\Adapter\Adapter;
use Zend\Filter\Word;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use Illuminate\Database\Capsule\Manager as Capsule;

class AdminController extends AbstractActionController{
    protected $serviceManager;
    protected $viewModel;
    const LIMIT = 10;

    public function __construct(ServiceManager $serviceManager){
        $this->serviceManager = $serviceManager;

        $this->viewModel = new ViewModel();

        $this->serviceManager->get("init-capsule");
    }

    public function paginationAction(){
        /** @var Request $request */
        $request = $this->getRequest();
        $routeMatch = $this->getEvent()->getRouteMatch();

        $pageId = $routeMatch->getParam('page');

        /**
         * Set controller, to pass it into paginator
         */
        $controller = $routeMatch->getParam('controller');
        $controllerTrimed = substr($controller, strrpos($controller, '\\') + 1);
        $controllerName = strtolower((new Word\CamelCaseToDash())->filter($controllerTrimed));
        $this->viewModel->setVariable("controller", $controllerName);

        /**
         * Set action, to pass it into paginator
         */
        $action = $this->getEvent()->getRouteMatch()->getParam('action');
        $this->viewModel->setVariable("action", $action);

        /**
         * Set order by, to pass it into paginator
         */
        $orderBy = ($orderBy = $routeMatch->getParam("order_by")) == null? "id" : $orderBy;
        $this->viewModel->setVariable("orderBy", $orderBy);

        /**
         * Set order, to pass it into paginator
         */
        $order = ($order = $routeMatch->getParam("order")) == null? "desc" : $order;
        $this->viewModel->setVariable("order", $order);

        /**
         * Create paginator dependencies
         * DbSelect
         */
        /**
         * build options for query
         */
        $options = array(
            UniQuery::ORDER_BY => $orderBy,
            UniQuery::ORDER => $order,
//            UniQuery::SEARCH_COLUMN => "province.name"
        );
        $searchTerm = $request->getQuery("search_term");
        if(!is_null($searchTerm)){
            $options[UniQuery::SEARCH_TERM] = $searchTerm;
            $requestGetParams = sprintf("?%s=%s", UniQuery::SEARCH_TERM, $searchTerm);
            $this->viewModel->setVariable("requestGetParams", $requestGetParams);
        }
        /**
         * inject adapter
         */
        /** @var Adapter $adapter */
//        $adapter = $this->serviceManager->get("adapter");
//
//        $query = new Select("post_features");
//        $query->where(new Like("name", "%" . $searchTerm . "%"));
//        $query->order($orderBy . " " . $order);
//
//        $dbSelect = new DbSelect($query, $adapter, null, null);
//        $paginator = new Paginator($dbSelect);
//
//        $paginator->setItemCountPerPage(self::LIMIT);
//
//        $paginator->setCurrentPageNumber($pageId);
//
//        var_dump($paginator->getItemsByPage($pageId));
//        $modelQuery = new PostFeature();
        $modelQuery = PostFeature::query();
//        $modelQuery = PostFeature::with("district")->query();
        $modelQuery->where("id", ">", 4);
        $query = Capsule::table('post_features');
        $query->where("id", ">", 10);
        $query2 =  Capsule::table('province')
            ->leftJoin('district', 'province.provinceid', '=', 'district.provinceid')
//            ->select('province.*', Capsule::raw('count(district.districtid) as count'))
            ->selectRaw("province.*, count(districtid) as countA")
            ->groupBy('province.provinceid');
//        var_dump($query2->toSql());
//        var_dump($query2->count());
//        $query3 = Capsule::table('province');
//        var_dump($query3->count());
//        $options[UniQuery::SEARCH_COLUMN] = "province.name";
//        $paginator = new Paginator(new UniQuery($query, $options));
//        $modelQuery->join("post_feature_detail", "post_features.id", "=", "post_feature_detail.post_features_id")
//            ->select("post_features.*");

//        $query = Capsule::table(Capsule::raw("(" . $modelQuery->toSql() . ") as T"));

        $paginator = new Paginator(new UniQuery($modelQuery, $options));
//        $paginator = new Paginator(new UniQuery($query, $options));

//        $paginator = new Paginator(new UniQuery($query2, $options));

        $paginator->setItemCountPerPage(self::LIMIT);

        $paginator->setCurrentPageNumber($pageId);

        var_dump($paginator->getTotalItemCount());

        $this->viewModel->setVariable("paginator", $paginator);

        foreach($paginator->getItemsByPage($pageId) as $item){
                var_dump($item->name);
//            var_dump($item->name. ", " . $item->count);
//            var_dump($item->name. ", " . $item->countA);
        }
//        var_dump(($paginator->getItemsByPage($pageId)->first()->name));

//        $urlParams = array(
//            'route' => 'test-regex-router/step',
//            "controller" => $controllerName,
//            "action" => $action,
//            UniQuery::ORDER_BY => $orderBy,
//            UniQuery::ORDER => $order,
//        );
//        $pages = get_object_vars($paginator->getPages());
//
//        $pages = array_merge($pages, $urlParams);

        return $this->viewModel;
    }

}