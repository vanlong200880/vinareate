<?php

namespace BackEnd\Factory;

use BackEnd\Controller\ProvinceController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProvinceControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
       /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new ProvinceController($sm); 
    }

}

