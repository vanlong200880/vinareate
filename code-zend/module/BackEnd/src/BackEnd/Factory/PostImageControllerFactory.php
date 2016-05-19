<?php

namespace BackEnd\Factory;

use BackEnd\Controller\PostImageController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostImageControllerFactory implements FactoryInterface{
    public function createService(ServiceLocatorInterface $serviceLocator) {
       /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new PostImageController($sm); 
//        return "a";
    }

}

