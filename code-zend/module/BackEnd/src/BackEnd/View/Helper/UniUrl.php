<?php
namespace BackEnd\View\Helper;

use Zend\Filter\Word;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Helper\AbstractHelper;

class UniUrl extends AbstractHelper{
    protected $sm;
    protected $controllerName;
    protected $action;

    public function __construct(ServiceManager $sm){
        $this->sm = $sm;
        /** @var MvcEvent $mvcEvent */
//        $mvcEvent = $sm->get("MvcEvent");
//
//        $this->action = $mvcEvent->getRouteMatch()->getParam("action");
//
//        $controller = $mvcEvent->getRouteMatch()->getParam("controller");
//        $controllerTrimed = substr($controller, strrpos($controller, '\\') + 1);
//        $controllerName = strtolower((new Word\CamelCaseToDash())->filter($controllerTrimed));
//        $this->controllerName = $controllerName;
    }

    /**
     * @param string $controller
     * @return string
     */
    public function __invoke(){
        return $this;
    }

    public function controllerName(){
        $this->controllerName = "controller";
        return $this->controllerName;
    }

    public function action(){
        $this->action = "action";
        return $this->action;
    }
}
