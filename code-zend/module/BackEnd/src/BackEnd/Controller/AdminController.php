<?php
namespace BackEnd\Controller;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Predicate\Like;
use Zend\Db\Sql\Select;
use Zend\Filter\Word;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController{
    protected $serviceManager;
    protected $viewModel;
    const LIMIT = 5;

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
            "order_by" => $orderBy,
            "order" => $order
        );
        $searchTerm = $request->getQuery("search_term");
        if(!is_null($searchTerm)){
            $options["search_term"] = $searchTerm;
            $this->viewModel->setVariable("searchTerm", "?search_term=" . $searchTerm);
        }
        /**
         * inject adapter
         */
        /** @var Adapter $adapter */
        $adapter = $this->serviceManager->get("adapter");

        $query = new Select("post_features");
        $query->where(new Like("name", "%" . $searchTerm . "%"));
        $query->order($orderBy . " " . $order);

        $dbSelect = new DbSelect($query, $adapter, null, null);
        $paginator = new Paginator($dbSelect);

        $paginator->setItemCountPerPage(self::LIMIT);

        $paginator->setCurrentPageNumber($pageId);

        var_dump($paginator->getItemsByPage($pageId));

        $this->viewModel->setVariable("paginator", $paginator);
        return $this->viewModel;
    }

}