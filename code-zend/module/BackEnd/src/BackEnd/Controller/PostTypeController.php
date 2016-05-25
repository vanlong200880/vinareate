<?php

namespace BackEnd\Controller;

use BackEnd\Database\PostTypeTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use BackEnd\Form\ValidatorProvince;
use BackEnd\Form\PostTypeForm;

class PostTypeController extends AbstractActionController {

    protected $serviceManager;
    protected $placequery;

    public function __construct($sm) {
        $this->serviceManager = $sm;
        $configDb = $this->serviceManager->get('config')["db"];
        $adapter = new Adapter($configDb);
        $this->placequery = new PostTypeTable($adapter);
    }

    public function indexAction() {
         $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam = $this->params()->fromRoute();
        $arrayParam['request'] = $postParams->toArray();
        $type=$this->params()->fromRoute('type');
        strtolower($col = $this->params()->fromRoute('col'));
        $col = ($col == 'desc')? 'asc': 'desc';
        $viewmodel=new ViewModel;
        $matches=$this->getEvent()->getRouteMatch();
        $page=$matches->getParam('page',1);
        $listprovince = $this->placequery->getAll('',$type,$col);
        $arrayAdapter=new \Zend\Paginator\Adapter\ArrayAdapter($listprovince);
        $paginator=new \Zend\Paginator\Paginator($arrayAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(4);
        $flash=$this->flashMessenger()->getMessages();
        $viewmodel->setVariable('data', $paginator);
        $viewmodel->setVariable('flash', $flash);        
        $viewmodel->setVariable('form', $form);        
        return array(
            'data' => $paginator,
            'sort'  => $col,
            'flash' => $flash,
            'form' => $form,
        );
    }

    public function addAction() {
        $view = new ViewModel();
        $form=new PostTypeForm();
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam['request'] = $postParams->toArray();
        if ($request->isPost()) {
             $data=$this->params()->fromPost();
              $form->setData($data);
             if($form->isValid()){
//                 $datainput=$form->getData();
                 $result = $this->placequery->saveData($arrayParam);
                $this->flashMessenger()->addMessage("thanh cong");
                return $this->redirect()->toRoute('backend/type');
             }
        }
        $data['arrayParam'] = $arrayParam;
        $data['title'] = 'Thêm trạng thái';
        $data['nameController'] = 'Trạng Thái';
       // $view->setVariable('data', $data); 
        $view->setVariable('form', $form); 
        return array(
            //data' => $data,
            'form' => $form,
        );
    }
    public function editAction(){
        $view = new ViewModel();
        $id = $this->params()->fromRoute('id');
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam = $this->params()->fromRoute();
        if ($id) {
            //get item from id
            $arrayParam['post'] = $this->placequery->getItemById($id);
             $arrayParam['request'] = $postParams->toArray();
              if ($request->isPost() == true) {
                  $edititem = $this->placequery->saveData($arrayParam);
                  $this->flashMessenger()->addMessage("Cập nhật trạng thái thành công");
                    return $this->redirect()->toRoute('backend/status');
              }
        }
        $view->setVariable('post', $arrayParam['post']);
        $view->setTemplate('post-status');
//       
        $data['title'] = 'Thêm trạng thái';
        $data['nameController'] = 'Trạng Thái';
        return $view;
    }

    public function delAction() {
        $id = $this->params()->fromRoute('id');
        //$result = $this->placequery->ListAllChild($id);
        $del=$this->placequery->delItemById($id);
        if ($del) {
            $this->flashMessenger()->addMessage("Xóa thành công");
            return $this->redirect()->toRoute('backend/status');
        }
//        
    }

  


}
