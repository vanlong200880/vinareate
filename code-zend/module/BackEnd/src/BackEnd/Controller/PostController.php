<?php
namespace BackEnd\Controller;

use BackEnd\Database\PostTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;


class PostController extends AbstractActionController{
    protected $serviceManager;

    public function __construct($sm){
        $this->serviceManager = $sm;
    }

    public function indexAction(){
        $new = new ViewModel();
        return $new;
    }

    public function createAction(){
        $new = new ViewModel();
        return $new;
    }
}