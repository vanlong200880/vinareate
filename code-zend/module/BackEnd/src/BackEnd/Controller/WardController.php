<?php

namespace BackEnd\Controller;

use BackEnd\Database\WardTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
//use Zend\View\Model\JsonModel;
use BackEnd\Form\ValidatorWard;

class WardController extends AbstractActionController {

    protected $serviceManager;
    protected $placequery;

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
        $arrayParam = '';
        $request = $this->getRequest();
        $postParams = $request->getPost();
//        $arrayParam['categofy']=$this->placequery->getCategory();
        if ($request->isPost()) {
            $arrayParam['request'] = $postParams->toArray();
            $nameward = explode(',', $postParams['nameward']);

            $validator = new ValidatorWard($arrayParam, null, $this->serviceManager);
            if ($validator->isError() == true) {
                $arrayParam['error'] = $validator->getMessagesError();
            } else {
                foreach ($nameward as $name) {
                    $name = ucwords($name);
                    $result = $this->placequery->saveData($arrayParam, $name);
                }
                return $this->redirect()->toRoute('backend/ward');
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
        $arrayParam = $this->params()->fromRoute();
        if ($id) {
            //get item from id
            $arrayParam['post'] = $this->placequery->getItemById($id);
            $arrayParam['request'] = $postParams->toArray();
            if ($request->isPost() == true) {

                $edititem = $this->placequery->saveData($arrayParam);
                return $this->redirect()->toRoute('backend/ward');
            }
        }
        $data['arrayParam'] = $arrayParam;
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

}
