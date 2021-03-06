<?php
namespace BackEnd;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module{
    const LAYOUT = "BACK_END_LAYOUT";

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

    public function onBootstrap(MvcEvent $e){
        $eventManager = $e->getApplication()->getEventManager();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
//        $e->getApplication()->getServiceManager()->get("ViewHelperManager")->fac
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function($mvcEvent){
            // Set the layout template
            $viewModel = $mvcEvent->getViewModel();
            $viewModel->setTemplate(self::LAYOUT);
        }, 1);
    }

}