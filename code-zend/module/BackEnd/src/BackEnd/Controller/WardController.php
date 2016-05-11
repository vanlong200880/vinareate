<?php

namespace BackEnd\Controller;

use BackEnd\Database\WardTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use BackEnd\Form\ValidatorWard;

class WardController extends AbstractActionController {

    protected $serviceManager;
    protected $placequery;
    protected $viewModel;

    public function __construct($sm) {
        $this->serviceManager = $sm;
//        $this->serviceManager();
//        $configDb = $this->serviceManager->get('config')["db"];
//        $adapter = new Adapter($configDb);
//        $this->placequery = new DistrictTable($adapter);
        $this->placequery = new WardTable($this->serviceManager->get('adapter'));
    }

    public function indexAction() {
        $listward = $this->placequery->getAll();
        
        return new ViewModel(array('data' => $listward));
    }

    public function addAction() {
        $view = $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
        $view->headScript()->appendFile($view->basePath() . "/js/ajax.js", "text/javascript");
        $arrayParam = '';
        $request = $this->getRequest();
        $postParams = $request->getPost();
//        $jsonModel->setVariable("id", $provinceId);
        $arrayParam['listcategory'] = $this->placequery->getCategory();
        if ($request->isPost()) {
            $arrayParam['request'] = $postParams->toArray();
//            echo "<pre>";
//            print_r($postParams);
            $nameward = explode(',', $postParams['nameward']);
            $validator = new ValidatorWard($arrayParam, null, $this->serviceManager);
            if ($validator->isError() == true) {
                $arrayParam['error'] = $validator->getMessagesError();
            } else {
                if (array_filter($nameward)) {
                    foreach ($nameward as $name) {
                        $name = ucwords($name);
                       $result = $this->placequery->saveData($arrayParam, $name);
                    }
                    return $this->redirect()->toRoute('backend/ward');
                } else {
                    $arrayParam['error'] = array("Dữ liệu không hợp lệ");
                }
            }
        }
        $data['arrayParam'] = $arrayParam;
        $data['title'] = 'Thêm Tỉnh thành';
        $data['nameController'] = 'Tỉnh thành';
        $view = new ViewModel($data);
        return $view;
    }

//
    public function editAction() {
        $id = $this->params()->fromRoute('id');
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam['request'] = $postParams->toArray();
        $arrayParam['listcategory'] = $this->placequery->getCategory();
        $validator = new ValidatorWard($arrayParam, null, $this->serviceManager);
        if ($id) {
            //get item from id
            $arrayParam['post'] = $this->placequery->getItemById($id);
            if ($request->isPost() == true) {
                if($validator->isError() == true){
                     $arrayParam['error'] = $validator->getMessagesError();
                }else{
                $edititem = $this->placequery->saveData($arrayParam);
                return $this->redirect()->toRoute('backend/ward');
                }
            }
        }
        $data['arrayParam'] = $arrayParam;
        $data['provinceid'] = $arrayParam['post']['id'];
        $data['title'] = 'Sửa Tỉnh thành';
        $view = new ViewModel($data);
        $view->setTemplate('ward_add_template');
        return $view;
    }

//
    public function delAction() {
        $id = $this->params()->fromRoute();
        $result = $this->placequery->delItemFromId($id);
        if ($result) {
            $this->flashMessenger()->addMessage("xoa thanh cong");
        }
        return $this->redirect()->toRoute('backend/ward');
    }

    public function ajaxAction() {
        $request = $this->getRequest();
        $postParams = $request->getPost();

        $provinceId = $postParams->get("id");
        $jsonModel = new JsonModel();
        if ($provinceId) {
            $data = $this->placequery->getListDistrict($provinceId);
            //$view->setVariable("wards", $test);
        }
        return new JsonModel(array('data' => $data));
    }

}
