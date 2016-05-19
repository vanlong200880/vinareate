<?php
namespace BackEnd\Factory;

use BackEnd\Controller\TestController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TestControllerFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ControllerManager|ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator){
        /**
         * get real service manager
         */
        $sm = (object)$serviceLocator->getServiceLocator();
        return new TestController($sm);
    }
}