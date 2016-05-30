<?php
namespace BackEnd\Controller;

use BackEnd\Model\PostFeature;
use Zend\Filter\Word;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class RegexRouterController extends IlluminateDatabaseController{
    protected $jsonModel;
    protected $viewModel;
    const LIMIT = 5;

    public function __construct(ServiceManager $sm){
        parent::__construct($sm);
        $this->jsonModel = new JsonModel();
        $this->viewModel = new ViewModel();
    }

    public function indexAction(){
        $pageId = $this->getEvent()->getRouteMatch()->getParam('page');
        $this->jsonModel->setVariable("index", array("page" => $pageId));
        return $this->jsonModel;
    }

    public function addAction(){
        $this->jsonModel->setVariable("add", array("name" => "anh"));
        return $this->jsonModel;
    }


    public function deleteAction(){
        $this->jsonModel->setVariable("delete", array("name" => "anh"));
        return $this->jsonModel;
    }


    public function editAction(){
        $this->jsonModel->setVariable("edit", array("name" => "anh"));
        return $this->jsonModel;
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
        $postFeatures = PostFeature::all()->toArray();
        $postFeature2s = PostFeature::skip($pageId * self::LIMIT)->limit(self::LIMIT)->get()->toArray();
//        var_dump($postFeatures);
        /**
         * handle paginator
         *
         */
        $paginator = new Paginator(new ArrayAdapter($postFeatures));
        $paginator->setItemCountPerPage(self::LIMIT);
        $paginator->setCurrentPageNumber($pageId);
        $this->viewModel->setVariable("paginator", $paginator);
        $this->viewModel->setVariable("controller", "regex-router");
        $this->viewModel->setVariable("action", $action);
        var_dump($paginator->getItemsByPage($pageId));
        return $this->viewModel;
    }
}