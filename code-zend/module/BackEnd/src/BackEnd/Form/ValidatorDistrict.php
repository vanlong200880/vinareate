<?php

namespace BackEnd\Form;

class ValidatorDistrict {

    protected $_messagesError = null;
    protected $sm;

    public function __construct($arrayParam = array(), $options = null, $sm) {
        $this->_arrData = $arrayParam;
        $this->sm = $sm;
        //check name
        $validator = new \Zend\Validator\ValidatorChain();
        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
        if (!$validator->isValid($arrayParam['request']['namedistrict'])) {
            $message = $validator->getMessages();
            $this->_messagesError['namecity'] = 'Tên Quận/Huyện: ' . current($message);
        }
//
//
//        //check name dulicate
//
//        $dbAdapter = $this->sm->get('adapter');
//        $namedistrict = explode(',', $arrayParam['request']['namedistrict']);
//        if (array_filter($namedistrict)) {
//            foreach ($namedistrict as $key => $name) {
//                $checkduplicate = new \Zend\Validator\Db\RecordExists(
//                        array(
//                    'table' => 'district2',
//                    'field' => 'name',
//                    'adapter' => $dbAdapter,
//                        )
//                );
//                if ($checkduplicate->isValid($name)) {
//                    $message = $validator->getMessages();
//                    $this->_messagesError['name'] = 'Tên Quận/Huyện này đã tồn tại';
//                }
//            }
//        }
    }



    public function checkNameDuplicate($arrayParam = array(), $sm) {
      
         $validator = new \Zend\Validator\ValidatorChain();
        $dbAdapter = $this->sm->get('adapter');
        $namedistrict = explode(',', $arrayParam['request']['namedistrict']);
        if (array_filter($namedistrict)) {
            foreach ($namedistrict as $key => $name) {
                $checkduplicate = new \Zend\Validator\Db\RecordExists(
                        array(
                    'table' => 'district2',
                    'field' => 'name',
                    'adapter' => $dbAdapter,
                        )
                );
                if ($checkduplicate->isValid($name)) {
                    $message = $validator->getMessages();
                   return  $this->_messagesError['name'] = 'Tên Quận/Huyện này đã tồn tại';
                    
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
