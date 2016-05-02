<?php
namespace FrontEnd\Factory;

use FrontEnd\Controller\PostController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class PostControllerFactory implements FactoryInterface{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface|ControllerManager $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator){
        /**
         * get real service manager
         * @var ServiceManager $serviceManger
         */
        $serviceManger = $serviceLocator->getServiceLocator();
        return new PostController($serviceManger);
    }
}