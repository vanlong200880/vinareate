<?php
namespace BackEnd\Controller;

use BackEnd\Database\CategoryTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use BackEnd\Form\ValidatorCategory;


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
    public function editAction(){
        $view=new ViewModel();
          $id=$this->params()->fromRoute('id');
          $request = $this->getRequest();
          $postParams=$request->getPost();
          $arrayParam=$this->params()->fromRoute();
          $arrayParam['request']=$postParams->toArray();
        $arrayParam['getParentCate']=$this->placequery->getParentCate();
          if($id){
//              //get item from id
              $arrayParam['post']=$this->placequery->getItemById($id);
              $validator = new ValidatorCategory($arrayParam, null, $this->serviceManager);
              if($request->isPost()){
                  if($validator->isError() == true) {
                      $arrayParam['error'] = $validator->getMessagesError();
                  }else{
                    $edititem=$this->placequery->saveData($arrayParam);
                    $this->flashMessenger()->addMessage("Sửa chuyên mục thành công"); 
                    return $this->redirect()->toRoute('backend/category');
                  }
            
                  
              }
          }
        
        $data['arrayParam'] = $arrayParam;
        $view->setVariable("data", $data);
        $view->setVariable("getparentcate", $arrayParam['getParentCate']);
        $view->setVariable("post", $arrayParam['post']);
        $view->setVariable("id", $id);
        if(isset($arrayParam['error']))$view->setVariable("error", $arrayParam['error']);
          $view->setTemplate('category_add_template');
          return $view;
    }
    public function addAction(){
        $view=new ViewModel();
        $request=$this->getRequest();
        $postParams=$request->getPost();
        $arrayParam = $this->params()->fromRoute();
        $arrayParam['request'] = $postParams->toArray();         
        $arrayParam['getParentCate']=$this->placequery->getParentCate();
        $validator = new ValidatorCategory($arrayParam, null, $this->serviceManager);
        if($request->isPost()){
             if($validator->isError() == true) {
                 $arrayParam['error'] = $validator->getMessagesError();
                
             }else{
//                 $title=$arrayParam['request']['nametitle'];
//                 $urltitle= $this->serviceManager->get('ViewHelperManager')->get('Unicode')->make($title);
////                 echo "<pre>";
////                 print_r($urltitle);
//                 die();
                $result=$this->placequery->saveData($arrayParam);
                $this->flashMessenger()->addMessage("Thêm Chuyên mục thành công ");
                return $this->redirect()->toRoute('backend/category');
             }
            
        }
        $data['arrayParam'] = $arrayParam;
        $view->setVariable("data", $data);
        $view->setVariable("getparentcate", $arrayParam['getParentCate']);
        if(isset($arrayParam['error']))$view->setVariable("error", $arrayParam['error']);
        return $view;
    }
    
}