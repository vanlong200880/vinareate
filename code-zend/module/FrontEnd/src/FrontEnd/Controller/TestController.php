<?php
namespace FrontEnd\Controller;

use Mobile_Detect;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class TestController extends AbstractActionController{

    protected $sm;
    /** @var Mobile_Detect mobileDetect */
    protected $mobileDetect;

    /**
     * TestController constructor.
     * @param ServiceManager $sm
     */
    public function __construct($sm){
        $this->sm = $sm;
        $this->mobileDetect = $this->sm->get('MobileDetect');
    }

    public function indexAction(){
        $json = new JsonModel();
        $json->setVariable("name", "hoanganh");
        unlink("public/images/storage-1.png");
        return $json;
    }

    public function mobileDetectAction(){
        $view = new ViewModel();

        $view->setVariable("mobileDetect", $this->mobileDetect);
        if($this->mobileDetect->isMobile()){
            $data = sprintf("hi, you are using mobile");
            $view->setVariable("isMobile", $data);
        }

        if($this->mobileDetect->isTablet()){
            $data = sprintf("hi, you are using tablet");
            $view->setVariable("isTablet", $data);
        }
        return $view;
    }
}