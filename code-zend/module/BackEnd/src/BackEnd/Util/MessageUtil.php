<?php
namespace BackEnd\Util;

use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class MessageUtil{

    protected $sessionError;
    protected $view;
    protected $layout;
    protected $msgs;

    /**
     * MessageController constructor.
     * @param Container $sessionError
     */
    public function __construct($sessionError){
        $this->view = new ViewModel();
        $this->view->setTemplate("msg-info");
        $this->sessionError = $sessionError;
        $this->msgs = array();
        if($this->sessionError->offsetExists("msg")){
            $this->msgs = $this->sessionError["msg"];
        }
    }

    /**
     * @param array|string $msg
     */
    public function set($msg){
        //handle on array
        if(is_array($msg)){
            $this->msgs = array_merge($this->msgs, $msg);
        }
        //handle on string
        if(!is_array($msg)){
            $this->msgs[] = $msg;
        }
        //load $msg back into sessionError
        //we need sessionError for CROSS page
        //when page changed, this controller init again
        //$msgs need sessionError as "initital value"
        $this->sessionError["msg"] = $this->msgs;
    }

    /**
     * @param ViewModel $layout
     */
    public function show($layout){
        $this->view->setVariable("msg", $this->msgs);
        $layout->addChild($this->view, "msgUtil");
        //after show it out
        //empty sessionError
        $this->sessionError->offsetUnset("msg");
    }
}