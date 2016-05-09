<?php

namespace BackEnd\Controller;

use BackEnd\Database\ProvinceTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use BackEnd\Form\ValidatorProvince;

class ProvinceController extends AbstractActionController {

    protected $serviceManager;
    protected $placequery;


    public function __construct($sm) {
        $this->serviceManager = $sm;
        $configDb = $this->serviceManager->get('config')["db"];
        $adapter = new Adapter($configDb);
        $this->placequery = new ProvinceTable($adapter);
    } 

    public function indexAction() {
        $listprovince = $this->placequery->getAll();
           $request = $this->getRequest();
           if($request->isPost() == true){
                 return $this->redirect()->toRoute('backend/province');
           }
           return new ViewModel(array('data' => $listprovince));
    }

    public function addAction() {
        $request = $this->getRequest();
        $postParams = $request->getPost();
        if ($request->isPost()) {
            $view = new JsonModel();
            $arrayParam['request'] = $postParams->toArray();
            $validator=new ValidatorProvince($arrayParam, null, $this->serviceManager);
            if($validator->isError()==true){
                $arrayParam['error'] = $validator->getMessagesError();
            }else{
            $result = $this->placequery->saveData($arrayParam);
            //$this->flashMessenger()->addMessage("thanh cong");
            return $this->redirect()->toRoute('backend/province');
            }
        }
        $data['arrayParam'] = $arrayParam;
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
        $id = $this->params()->fromRoute('id');
        $request=$this->getRequest();
        $postParams = $request->getPost(); 
        $arrayParam = $this->params()->fromRoute();
        if($id){
            //get item from id
            $arrayParam['post']=$this->placequery->getItemById($id);
            $arrayParam['request']=$postParams->toArray();
            if($request->isPost() == true){
                $edititem =$this->placequery->saveData($arrayParam);
                echo "success"; 
                return $this->redirect()->toRoute('backend/province');
                
            }
        }
//        echo "<pre>";
//        print_r($arrayParam);
        $data['arrayParam'] = $arrayParam;
        $data['title'] = 'Sửa Tỉnh thành';
        $view = new ViewModel($data);
         $view->setTemplate('province_add_template');
         return $view;
    }
    

}
