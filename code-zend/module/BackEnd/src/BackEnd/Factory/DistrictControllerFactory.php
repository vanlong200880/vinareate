<?php

namespace BackEnd\Factory;

use BackEnd\Controller\DistrictController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DistrictControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
       /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new DistrictController($sm); 
    }

}

