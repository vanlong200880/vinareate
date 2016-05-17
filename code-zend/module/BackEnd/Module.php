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
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function($mvcEvent){
            // Set the layout template
            $viewModel = $mvcEvent->getViewModel();
            $viewModel->setTemplate(self::LAYOUT);
        }, 1);
//         echo '<pre>';
            }
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'adapter' => function($sm) {
                    $adapter=$sm->get('Zend\Db\Adapter\Adapter');
                },
                 'SanSamplePagination\Database\DistrictTable' =>function($sm){ 
		    $table = new Database\DistrictTable(); 
		    return $table;
                },
                
            )
        );
    }
}