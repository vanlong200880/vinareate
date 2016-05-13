<?php
namespace FrontEnd\Controller;

use FrontEnd\Database\HousePosition;
use FrontEnd\UIObject\PostTabView;
use Zend\Db\Adapter\Adapter;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController{
    protected $serviceManager;
    protected $placeQuery;
    protected $postTabView;

    /**
     * PostController constructor.
     * @param ServiceManager $sm
     */
    public function __construct($sm){
        $this->serviceManager = $sm;

        $configDb = $this->serviceManager->get('config')["db"];
        $adapter = new Adapter($configDb);
        $this->placeQuery = new HousePosition($adapter);

        $this->postTabView = new PostTabView();
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
        //        $adapter = $this->serviceManager->get("adapter");
        //        $placeQuery = new PlaceQuery($adapter);

        $provinces = $this->placeQuery->getProvinces();
        $uiProvinces = $this->postTabView->getProvincesOption($provinces);
        $view->setVariable('provinces', $uiProvinces);
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
            $view = new JsonModel();

            $postParams = $request->getPost();
            $provinceid = $postParams->get("provinceid");

            $districts = $this->placeQuery->getDistrictOnProvinceId($provinceid);
            $uiDistricts = $this->postTabView->getDistrictsOption($districts);
            $view->setVariable("districts", $uiDistricts);

            return $view;
        }
        die("not handle request GET");
    }

    public function wardAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $postParams = $request->getPost();
            $wardid = $postParams->get("districtid");

            $wards = $this->placeQuery->getWardOnDistrictId($wardid);
            $uiWards = $this->postTabView->getWardsOption($wards);
            $view->setVariable("wards", $uiWards);

            return $view;
        }
        die("not handle request GET");
    }

    public function parentCategoryAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            //            $postParams = $request->getPost();

            $parentCategories = $this->placeQuery->getParentCategory();
            $uiParentCategories = $this->postTabView->getParentCategoryOption($parentCategories);
            $view->setVariable("parentCategory", $uiParentCategories);

            return $view;
        }
        die("not handle request GET");
    }

    public function categoryAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $postParams = $request->getPost();
            $parentCategoryId = $postParams->get("parentCategoryId");

            $categories = $this->placeQuery->getCategory($parentCategoryId);
            $uiCategories = $this->postTabView->getCategoryOption($categories);
            $view->setVariable("category", $uiCategories);
            return $view;
        }
        die("not handle request GET");
    }

    public function featureAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $features = $this->placeQuery->getAllFeatures();
//            $uiCategories = $this->postTabView->getCategoryOption($categories);
            $view->setVariable("features", $features);
            return $view;
        }
        die("not handle request GET");
    }
}