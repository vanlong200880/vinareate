<?php

namespace BackEnd\Form;

class ValidatorCategory {

    protected $_messagesError = null;
    protected $sm;

    public function __construct($arrayParam = array(), $options = null, $sm) {
        $this->_arrData = $arrayParam;
        $this->sm = $sm;

//        //check name title
        $validator = new \Zend\Validator\ValidatorChain();
        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
        if (isset($arrayParam['request']['nametitle']) && !$validator->isValid($arrayParam['request']['nametitle'])) {
            $message = $validator->getMessages();
            $this->_messagesError['nametitle'] = 'Tên chuyên mục: ' . current($message);
        }
////        //check name metatitle
//        $validator = new \Zend\Validator\ValidatorChain();
//        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
//        if (isset($arrayParam['request']['metatitle']) && !$validator->isValid($arrayParam['request']['metatitle'])) {
//            $message = $validator->getMessages();
//            $this->_messagesError['nameslug'] = 'Meta title chuyên mục: ' . current($message);
//        }
////        //check name keyword
//        $validator = new \Zend\Validator\ValidatorChain();
//        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
//        if (isset($arrayParam['request']['metakeyword']) && !$validator->isValid($arrayParam['request']['metakeyword'])) {
//            $message = $validator->getMessages();
//            $this->_messagesError['metakeyword'] = 'meta keyword: ' . current($message);
//        }
        
    }

//    public function checkNameDuplicate($arrayParam = array(), $sm) {
//
//        $validator = new \Zend\Validator\ValidatorChain();
//        $dbAdapter = $this->sm->get('adapter');
//        $checkduplicate = new \Zend\Validator\Db\RecordExists(
//                array(
//            'table' => 'category',
//            'field' => 'name',
//            'adapter' => $dbAdapter,
//                )
//        );
//        if ($checkduplicate->isValid($arrayParam['request']['nametitle'])) {
//            $message = $validator->getMessages();
//            return $this->_messagesError['name'] = 'Tên Chuyên mục này đã tồn tại';
//            
//        }
//    }

    public function isError() {
        if (count($this->_messagesError) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMessagesError() {
        return $this->_messagesError;
    }

}
