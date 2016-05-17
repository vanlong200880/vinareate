<?php
namespace FrontEnd;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module{
    const LAYOUT = "FRONT_END_LAYOUT";

    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $mvcEvent){
        $eventManager = $mvcEvent->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
//        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function($mvcEvent){
//            // Set the layout template
//            $viewModel = $mvcEvent->getViewModel();
//            var_dump("set frontend layout");
//            $viewModel->setTemplate(self::LAYOUT);
//        }, 10);
    }

}