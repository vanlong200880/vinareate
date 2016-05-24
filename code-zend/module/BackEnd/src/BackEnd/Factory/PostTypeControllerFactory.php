<?php

namespace BackEnd\Factory;

use BackEnd\Controller\PostTypeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostTypeControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
       /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new PostTypeController($sm); 
//        return "a";
    }

}

