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
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new PostController($sm);
    }
}