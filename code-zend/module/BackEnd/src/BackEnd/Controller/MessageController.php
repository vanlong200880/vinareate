<?php
namespace BackEnd\Controller;

class MessageController{

    protected $sessionError;
    protected $msg;

    public function __construct($sessionError){
        $this->sessionError = $sessionError;
        $this->msg = array();
        $this->sessionError->msg = $this->msg;
    }

    /**
     * @param array|string $msg
     */
    public function setSessionError($msg){
        //handle on array
        if(is_array($msg)){
            $this->msg = array_merge($this->msg, $msg);
        }
        //handle on string
        if(!is_array($msg)){
            $this->msg[] = $msg;
        }
        $this->sessionError->msg = $this->msg;
    }

    public function msg(){
        /**
         * show msg
         */
        var_dump($this->sessionError->msg);
        /**
         * remove, to load new one
         */
        $this->sessionError->msg = array();
    }
}