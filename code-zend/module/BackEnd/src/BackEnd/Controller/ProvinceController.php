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
        
        $viewmodel=new ViewModel;
        $this->controller = $this;
        $matches=$this->getEvent()->getRouteMatch();
        $page=$matches->getParam('page',1);
        $listprovince = $this->placequery->getDistrictbyProvinceID();
        //$listprovince = $this->placequery->getAll();
        //$district=$this->placequery->getDistrictbyProvinceID();
        $arrayAdapter=new \Zend\Paginator\Adapter\ArrayAdapter($listprovince);
        $paginator=new \Zend\Paginator\Paginator($arrayAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(4);
        $viewmodel->setVariable('data', $paginator);
        
        return array(
            'data' => $paginator,
            'district' => $district,
        );
    }

    public function addAction() {
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam['request'] = $postParams->toArray();
        if ($request->isPost()) {
            $view = new JsonModel();
            $validator = new ValidatorProvince($arrayParam, null, $this->serviceManager);
            if ($validator->checkNameDuplicate($arrayParam, $this->serviceManager) || $validator->isError() == true) {
                $arrayParam['error'] = $validator->getMessagesError();
            } else {
                $result = $this->placequery->saveData($arrayParam);
//            //$this->flashMessenger()->addMessage("thanh cong");
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
        $request = $this->getRequest();
        $postParams = $request->getPost();
        $arrayParam = $this->params()->fromRoute();
        if ($id) {
            //get item from id
            $arrayParam['post'] = $this->placequery->getItemById($id);
            
            if ($request->isPost() == true) {
                 $arrayParam['request'] = $postParams->toArray();
                 $validator = new ValidatorProvince($arrayParam, null, $this->serviceManager);
                if ($validator->isError() == true) {
                    $arrayParam['error'] = $validator->getMessagesError();
                } else {
                    $edititem = $this->placequery->saveData($arrayParam);
                    return $this->redirect()->toRoute('backend/province');
                }
            }
        }
        $data['arrayParam'] = $arrayParam;
        $data['title'] = 'Sửa Tỉnh thành';
        $view = new ViewModel($data);
        $view->setTemplate('province_add_template');
        return $view;
    }
    public function districtAction(){
        $province_id = $this->params()->fromRoute('id');
//        echo $province_id;
        $request = $this->getRequest();
        $postParams = $request->getPost();
//        $arrayParam['request'] = $postParams->toArray();
        $district=$this->placequery->getDistrictbyProvinceID($province_id);
//        echo "<pre>";
//        print_r($district);
//        if ($request->isPost()) {
//            $validator = new ValidatorProvince($arrayParam, null, $this->serviceManager);
//            if ($validator->checkNameDuplicate($arrayParam, $this->serviceManager) || $validator->isError() == true) {
//                $arrayParam['error'] = $validator->getMessagesError();
//            } else {
//                $result = $this->placequery->saveData($arrayParam);
////            //$this->flashMessenger()->addMessage("thanh cong");
//                return $this->redirect()->toRoute('backend/province');
//            }
//        }
//        $data['arrayParam'] = $arrayParam;
//        $data['title'] = 'danh Sách Quận huyện theo Tỉnh/Thành';
        $view = new ViewModel(array('data'=>$district));
        return $view;
    }

}
