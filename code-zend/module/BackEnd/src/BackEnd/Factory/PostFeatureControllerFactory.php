<?php

namespace BackEnd\Factory;

use BackEnd\Controller\PostFeatureController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class PostFeatureControllerFactory implements FactoryInterface{
    /**
     * @param ServiceLocatorInterface|ControllerManager $serviceLocator
     * @return PostFeatureController
     */
    public function createService(ServiceLocatorInterface $serviceLocator){
        /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new PostFeatureController($sm);
    }
}

