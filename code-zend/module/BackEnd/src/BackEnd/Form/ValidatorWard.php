<?php

namespace BackEnd\Form;

class ValidatorWard {

    protected $_messagesError = null;
    protected $sm;

    public function __construct($arrayParam = array(), $options = null, $sm) {
        $this->_arrData = $arrayParam;
        $this->sm = $sm;
//        //check name
        $validator = new \Zend\Validator\ValidatorChain();
        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
        if (isset($arrayParam['request']['nameward']) && !$validator->isValid($arrayParam['request']['nameward'])) {
            $message = $validator->getMessages();
            $this->_messagesError['nameward'] = 'Tên Phường/Xã: ' . current($message);
        }
        //check province
        $validator = new \Zend\Validator\ValidatorChain();
        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
        if (isset($arrayParam['request']['select_province']) && !$validator->isValid($arrayParam['request']['select_province'])) {
            $message = $validator->getMessages();
            $this->_messagesError['select_province'] = 'Tên Tỉnh/Thành: ' . current($message);
        }
        
        //check district
        $validator = new \Zend\Validator\ValidatorChain();
        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
        if (isset($arrayParam['request']['select_district']) && !$validator->isValid($arrayParam['request']['select_district'])) {
            $message = $validator->getMessages();
            $this->_messagesError['select_district'] = 'Tên Quận/Huyện: ' . current($message);
        }
//        //check name dulicate
//
//        $dbAdapter = $this->sm->get('adapter');
//        $namedistrict = explode(',', $arrayParam['request']['nameward']);
//        if (array_filter($namedistrict)) {
//            foreach ($namedistrict as $key => $name) {
//                $checkduplicate = new \Zend\Validator\Db\RecordExists(
//                        array(
//                    'table' => 'ward2',
//                    'field' => 'name',
//                    'adapter' => $dbAdapter,
//                        )
//                );
//                if ($checkduplicate->isValid($name)) {
//                    $message = $validator->getMessages();
//                    $this->_messagesError['name'] = 'Tên Phường/Xã này đã tồn tại';
//                }
//            }
//        }
    }

    public function checkNameDuplicate($arrayParam = array(), $sm) {

        $validator = new \Zend\Validator\ValidatorChain();
        $dbAdapter = $this->sm->get('adapter');
        $nameward = explode(',', $arrayParam['request']['nameward']);
        if (array_filter($nameward)) {
            foreach ($nameward as $key => $name) {
                $checkduplicate = new \Zend\Validator\Db\RecordExists(
                        array(
                    'table' => 'ward',
                    'field' => 'name',
                    'adapter' => $dbAdapter,
                        )
                );
                if ($checkduplicate->isValid($name)) {
                    $message = $validator->getMessages();
                    return $this->_messagesError['name'] = 'Tên Quận/Huyện này đã tồn tại';
                }
            }
        }
    }

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
