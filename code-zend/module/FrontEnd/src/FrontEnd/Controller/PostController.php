<?php
namespace FrontEnd\Controller;

use FrontEnd\Database\PlaceQuery;
use Zend\Db\Adapter\Adapter;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController{
    protected $serviceManager;

    /**
     * PostController constructor.
     * @param ServiceManager $sm
     */
    public function __construct($sm){
        $this->serviceManager = $sm;
    }

    public function indexAction(){
        $view = new ViewModel();


        return $view;
    }

    public function tabAction(){
        $view = new ViewModel();

        /**
         * get province data from database
         */
//        $configDb = $this->serviceManager->get('config')["db"];
//        $adapter = new Adapter($configDb);
        $adapter = $this->serviceManager->get("adapter");
        $placeQuery = new PlaceQuery($adapter);
        $provinces = $placeQuery->getProvinces();
        $view->setVariable('provinces', $provinces);
        return $view;
    }

    /**
     * only handle post method
     * return district base on provinceid
     */
    public function districtAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $postParams = $request->getPost();
            $provinceid = $postParams->get("provinceid");

            $adapter = $this->serviceManager->get("adapter");
            $placeQuery = new PlaceQuery($adapter);
            $districts = $placeQuery->getDistrictOnProvinceId($provinceid);
            $view = new JsonModel();

            $view->setVariable("districts", $districts);
            return $view;
        }
        die("not handle request GET");
    }

    public function wardAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $postParams = $request->getPost();
            $districtid = $postParams->get("provinceid");

            $adapter = $this->serviceManager->get("adapter");
            $placeQuery = new PlaceQuery($adapter);
            $wards = $placeQuery->getWardOnDistrictId($districtid);
            $view = new JsonModel();

            $view->setVariable("wards", $wards);
            return $view;
        }
        die("not handle request GET");
    }
}