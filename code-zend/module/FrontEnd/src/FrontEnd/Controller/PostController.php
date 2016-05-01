<?php
namespace FrontEnd\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController{
    public function indexAction(){
        $view = new ViewModel();
        return $view;
    }

    public function tabAction(){
        $view = new ViewModel();
        return $view;
    }
}