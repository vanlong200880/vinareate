<?php

namespace BackEnd\Factory;

use BackEnd\Controller\WardController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WardControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
       /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new WardController($sm); 
        
    }

}