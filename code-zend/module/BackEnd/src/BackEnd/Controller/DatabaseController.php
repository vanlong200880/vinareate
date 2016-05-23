<?php
namespace BackEnd\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;

class DatabaseController extends AbstractActionController{
    protected $serviceManager;

    /**
     * DatabaseController constructor.
     * @param ServiceManager $sm
     */
    public function __construct($sm){
        $this->serviceManager = $sm;

        $this->serviceManager->get("init-capsule");
    }
}