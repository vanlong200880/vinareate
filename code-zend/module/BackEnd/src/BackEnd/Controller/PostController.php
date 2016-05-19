<?php
namespace BackEnd\Controller;

use BackEnd\Database\PostTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;



class PostController extends AbstractActionController{
     protected $serviceManager;
    protected $placequery;
      public function __construct($sm) {
        $this->serviceManager = $sm;
        $this->placequery = new PostTable($this->serviceManager->get('adapter'));
    }
    public function indexAction() {
        $new=new ViewModel();
        $list=$this->placequery->getAll();
        $new->setVariable('data', $list);
        return $new;
//        $a = new A();
//        return $a->createService();
        //return new ViewModel(array('data'=>$list));
    }
//    public function delAction(){
//        $new = new ViewModel();
//        $id=$this->params()->fromRoute('id');
//        $request=$this->getRequest();
//        if($id) $this->placequery->getPostAndDelAll($id);
//        return $this->response;
//    }
}