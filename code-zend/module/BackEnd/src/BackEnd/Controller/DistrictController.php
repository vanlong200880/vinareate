<?php

namespace BackEnd\Controller;

use BackEnd\Database\DistrictTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\View\Model\JsonModel;
use BackEnd\Form\ValidatorDistrict;

class DistrictController extends AbstractActionController {

    protected $serviceManager;
    protected $placequery;

    public function __construct($sm) {
        $this->serviceManager = $sm;
//        $this->serviceManager();
//        $configDb = $this->serviceManager->get('config')["db"];
//        $adapter = new Adapter($configDb);
//        $this->placequery = new DistrictTable($adapter);
        $this->placequery = new DistrictTable($this->serviceManager->get('adapter'));
    }

    public function indexAction() {
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam = $this->params()->fromRoute();
        $arrayParam['request'] = $postParams->toArray();
        $type=$this->params()->fromRoute('type');
        strtolower($col = $this->params()->fromRoute('col'));
        $col = ($col == 'desc')? 'asc': 'desc';
        $viewmodel = new ViewModel;
        $matches = $this->getEvent()->getRouteMatch();
        $page      = $matches->getParam('page', 1);
        $listdistrict = $this->placequery->getAll($type,$col);
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($listdistrict);
        $paginator = new \Zend\Paginator\Paginator($arrayAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);
        $viewmodel->setVariable('paginator', $paginator);
        return array(
            'paginator'=>$paginator,
            'sort'      => $col,
                
        );
    }

    public function addAction() {
        $arrayParam = '';
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam['listcategory'] = $this->placequery->getCategory();

        if ($request->isPost()) {

            $arrayParam['request'] = $postParams->toArray();
            $namedistrict = explode(',', $postParams['namedistrict']);
                $validator = new ValidatorDistrict($arrayParam, null, $this->serviceManager);
                if ($validator->checkNameDuplicate($arrayParam, $this->serviceManager)|| $validator->isError() == true) {
                    $arrayParam['error'] = $validator->getMessagesError();
                } else {
                    if (array_filter($namedistrict)) {
                        foreach ($namedistrict as $name) {
                            $name = ucwords($name);
                            $result = $this->placequery->saveData($arrayParam, $name);
                        }
                 ////   $this->flashMessenger()->addMessage("thanh cong");
                        return $this->redirect()->toRoute('backend/district');
                    }else{                       
                        $arrayParam['error'] =array("Dữ liệu không hợp lệ");
                    }
                }
        }
        $data['arrayParam'] = $arrayParam;
        $data['title'] = 'Thêm Tỉnh thành';
        $data['nameController'] = 'Tỉnh thành';
        
        $view = new ViewModel($data);
        return $view;
    }

    public function editAction() {
        $id = $this->params()->fromRoute('id');
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam = $this->params()->fromRoute();
        
        if ($id) {
            $arrayParam['listcategory'] = $this->placequery->getCategory();

            //get item from id
            $arrayParam['post'] = $this->placequery->getItemById($id);
            //var_dump($arrayParam['post']['province_id']);
            $arrayParam['request'] = $postParams->toArray();
            $validator = new ValidatorDistrict($arrayParam, null, $this->serviceManager);
            if ($request->isPost() == true) {
                if($validator->isError() == true){
                     $arrayParam['error'] = $validator->getMessagesError();
                }else{
                $edititem = $this->placequery->saveData($arrayParam);
                return $this->redirect()->toRoute('backend/district');
                
                }
            }
        }
        $data['arrayParam'] = $arrayParam;
        $data['title'] = 'Sửa Tỉnh thành';
        $data['id'] = $arrayParam['post']['province_id'];
        $view = new ViewModel($data);
        $view->setTemplate('district_add_template');
        return $view;
    }

    public function delAction() {
        $id = $this->params()->fromRoute();
        $result = $this->placequery->delItemFromId($id);
        if ($result) {
            $this->flashMessenger()->addMessage("xoa thanh cong");
        }
        return $this->redirect()->toRoute('backend/district');
    }
    public function getSampleTable()
    {
        if (!$this->sampletable){
            $this->sampletable = $this->getServiceLocator()->get('SanSamplePagination\Database\DistrictTable');
        }
        return $this->sampletable;
    }

}
