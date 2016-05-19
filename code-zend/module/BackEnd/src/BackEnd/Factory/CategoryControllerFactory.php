<?php

namespace BackEnd\Factory;

use BackEnd\Controller\CategoryController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CategoryControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
       /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new CategoryController($sm); 
//        return "a";
    }

}

