<?php

namespace BackEnd\Controller;

use BackEnd\Database\ProvinceTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;

class ProvinceController extends AbstractActionController {

    protected $serviceManager;
    protected $placequery;

//    public function ad($sm) {
//        $this->a = $sm;
////        $this->serviceManager = $sm;
////        $configDb = $this->serviceManager->get('config')["db"];
////        $adapter = new Adapter($configDb);
////        $this->placequery = new ProvinceTable($adapter);
//    }
    public function __construct($sm) {
        $this->serviceManager = $sm;
        $configDb = $this->serviceManager->get('config')["db"];
        $adapter = new Adapter($configDb);
        $this->placequery = new ProvinceTable($adapter);
    }

    public function indexAction() {
        $listprovince = $this->placequery->getAll();

        return new ViewModel(array('data' => $listprovince));
    }

    public function addAction() {
        $request = $this->getRequest();
        $postParams = $request->getPost();
        if ($request->isPost()) {
            $view = new JsonModel();
            $arrayParam['post'] = $postParams->toArray();
            $result = $this->placequery->saveData($arrayParam);
            //$this->flashMessenger()->addMessage("thanh cong");
            return $this->redirect()->toRoute('backend/province');
        }
        $data['arrayParam'] = $postParams;
        $data['title'] = 'Thêm Tỉnh thành';
        $data['nameController'] = 'Tỉnh thành';
        $view = new ViewModel($data);
        return $view;
    }

    public function delAction() {
        $id = $this->params()->fromRoute('id');
        $result = $this->placequery->delItemFromId($id);
        if ($result) {
            $this->flashMessenger()->addMessage("xoa thanh cong");
        }
        return $this->redirect()->toRoute('backend/province');
    }
    public function editAction() {
//        $id = $this->params()->fromRoute('id');
//        $request=$this->getRequest();
//        $postParams = $request->getPost();       
//        if($id){
//            $arrayParam['post']=$this->placequery->getItemById($id);
//            echo "<pre>";
//            print_r($arrayParam['post']);
//            $edititem =$this->placequery->saveData();        
//        }
//        $data['arrayParam'] = $arrayParam;
//        $data['title'] = 'Sửa Tỉnh thành';
        $view = new ViewModel();
        return $view->setTemplate('backend/province/add.phtml');
    }
    

}
