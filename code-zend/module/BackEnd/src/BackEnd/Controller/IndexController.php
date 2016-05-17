<?php
namespace BackEnd\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use BackEnd\Module;

class IndexController extends AbstractActionController{
    public function indexAction(){
//        $layout = $this->layout();
//        $layout->setTemplate(Module::LAYOUT);
        return new ViewModel();
    }
    public function abcAction(){
        return new ViewModel();
    }
}