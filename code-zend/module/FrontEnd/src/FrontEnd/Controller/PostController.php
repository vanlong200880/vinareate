<?php
namespace FrontEnd\Controller;

use FrontEnd\Database\PlaceQuery;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
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
        $placeQuery = new PlaceQuery($this->serviceManager->get('adpater'));
        $provinces = $placeQuery->getProvinces();
        $view->setVariable('provinces', $provinces);
        return $view;
    }
}