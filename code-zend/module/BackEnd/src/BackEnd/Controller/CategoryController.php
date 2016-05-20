<?php
namespace BackEnd\Controller;

use BackEnd\Database\CategoryTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;


class CategoryController extends AbstractActionController{
     protected $serviceManager;
    protected $placequery;
      public function __construct($sm) {
        $this->serviceManager = $sm;
        $this->placequery = new CategoryTable($this->serviceManager->get('adapter'));
    }
    public function indexAction() {
        $new=new ViewModel();
        $list=$this->placequery->getAll();
        $flash=$this->flashMessenger()->getMessages();
        $new->setVariable('data', $list);
        $new->setVariable('flash', $flash);
        return $new;

        //return new ViewModel(array('data'=>$list));
    }
    public function delAction(){
        $new = new ViewModel();
        $id=$this->params()->fromRoute('id');
        $request=$this->getRequest();
        if($id) {
          $result=$this->placequery->getPostAndDelAll($id);

         if($result==true){
             $this->flashMessenger()->addMessage("Xóa Chuyên mục và dữ liệu liên quan thành công  ");
             return $this->redirect()->toRoute('backend/category');
         }
        }
        
//        return $this->response;
    }
    public function edtAction(){
          $id=$this->params()->fromRoute('id');
          if($id){
              $edit=$this->placequery->saveData($id);
          }
    }
}