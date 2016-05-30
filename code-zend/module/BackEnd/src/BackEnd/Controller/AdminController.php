<?php
namespace BackEnd\Controller;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
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
        $e = $this->getEvent();
        $pageId = $this->getEvent()->getRouteMatch()->getParam('page');
        $controller = $this->getEvent()->getRouteMatch()->getParam('controller');
        $action = $this->getEvent()->getRouteMatch()->getParam('action');

        /**
         * logic pagination
         */
//        $numberOfFeatures = PostFeature::all()->count();
//        $postFeatures = PostFeature::skip($pageId * self::LIMIT)->limit(self::LIMIT)->get()->toArray();
//        var_dump($postFeatures);
        /**
         * handle paginator
         *
         */
        /** @var Adapter $adapter */
        $select = new DbSelect(new Select("post_features"), $this->serviceManager->get("adapter"));
        $paginator = new Paginator($select);
//        $pageRange = (int)($numberOfFeatures / self::LIMIT) + 1;
//        $paginator->setPageRange($pageRange);
        $paginator->setItemCountPerPage(self::LIMIT);
        $paginator->setCurrentPageNumber($pageId);
        $this->viewModel->setVariable("paginator", $paginator);
        $this->viewModel->setVariable("controller", "admin");
        $this->viewModel->setVariable("action", $action);
//        var_dump($paginator->getItemsByPage($pageId));
        return $this->viewModel;
    }

}