<?php

namespace BackEnd\Form;

class ValidatorProvince {

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
            $this->_messagesError['namecity'] = 'Tên thành phố: ' . current($message);
        }
//        //check name metatitle
        $validator = new \Zend\Validator\ValidatorChain();
        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
        if (isset($arrayParam['request']['metatitle']) && !$validator->isValid($arrayParam['request']['metatitle'])) {
            $message = $validator->getMessages();
            $this->_messagesError['namecity'] = 'Tên thành phố: ' . current($message);
        }
//        //check name keyword
        $validator = new \Zend\Validator\ValidatorChain();
        $validator->addValidator(new \Zend\Validator\NotEmpty(), true);
        if (isset($arrayParam['request']['metakeyword']) && !$validator->isValid($arrayParam['request']['metakeyword'])) {
            $message = $validator->getMessages();
            $this->_messagesError['namecity'] = 'Tên thành phố: ' . current($message);
        }

    }

    public function checkNameDuplicate($arrayParam = array(), $sm) {

        $validator = new \Zend\Validator\ValidatorChain();
        $dbAdapter = $this->sm->get('adapter');
        $checkduplicate = new \Zend\Validator\Db\RecordExists(
                array(
            'table' => 'province',
            'field' => 'name',
            'adapter' => $dbAdapter,
                )
        );
        if ($checkduplicate->isValid($arrayParam['request']['namecity'])) {
            $message = $validator->getMessages();
            return $this->_messagesError['name'] = 'Tên Tỉnh\Thành này đã tồn tại';
            
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
