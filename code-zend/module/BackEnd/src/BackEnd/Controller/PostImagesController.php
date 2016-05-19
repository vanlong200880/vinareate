<?php
namespace BackEnd\Controller;

use BackEnd\Database\PostImageTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;


class PostImagesController extends AbstractActionController{
     protected $serviceManager;
    protected $placequery;
      public function __construct($sm) {
        $this->serviceManager = $sm;
        $this->placequery = new PostImageTable($this->serviceManager->get('adapter'));
    }
    public function indexAction() {      
        $new=new ViewModel();
        //$list=$this->placequery->getAll();  
       $data=array(1,7);
        $list=$this->placequery->DelPostbyPostID($data);
       return new ViewModel(array('data'=>$list));
    }
    public function delAction(){
        $new = new ViewModel();
       $id=$this->params()->fromRoute('id');
       echo $id;
//        $request=$this->getRequest();
//        if($id) $this->placequery->getPostAndDelAll($id);
        $data(array(5,6));
//        $this->placequery->getPostAndDelAll($data);
        //return $this->response;
    }
    
}