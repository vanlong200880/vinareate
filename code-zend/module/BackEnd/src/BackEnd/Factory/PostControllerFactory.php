<?php
namespace BackEnd\Factory;

use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

abstract class A implements FactoryInterface{

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
class PostControllerFactory extends \BackEnd\Factory\A{
    public function createService(ServiceLocatorInterface $serviceLocator){
        /**
         * get real ServiceManager
         */
        /** @var ServiceManager $sm */
        $sm = $serviceLocator->getServiceLocator();
        return new \BackEnd\Controller\PostController($sm);
    }
}





