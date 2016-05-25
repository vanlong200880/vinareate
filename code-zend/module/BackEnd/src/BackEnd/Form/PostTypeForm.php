<?php

namespace BackEnd\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PostTypeForm extends form {

    public function __construct() {
        parent::__construct('type_form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements() {
        $this->add(
                array(
                    'type' => 'text',
                    'name' => 'type',
                    'attributes' => array(
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'label' => 'tên type'
                    ),
                )
        );
        $this->add(
                array(
                    'type' => 'textarea',
                    'name' => 'description',
                    'attributes' => array(
                        'class' => 'form-control',
                        'row' => '5',
                    ),
                    'options' => array(
                        'label' => 'Mô tả'
                    ),
                )
        );
        $this->add(
                array(
                    'type' => 'text',
                    'name' => 'price',
                    'attributes' => array(
                        'class' => 'form-control'
                    ),
                    'options' => array(
                        'label' => 'gía'
                    ),
                )
        );
        $this->add(
                array(
                    'type' => 'submit',
                    'name' => 'submit',
                    'attributes' => array(
                        'class' => 'btn btn-primary',
                        'value' => 'submit'
                    ),
                )
        );
    }
    public function addInputFilter(){
        $input=new InputFilter;
        $this->setInputFilter($input);
        $input->add(
                array(
                    'name' =>'type',
                    'required'=>true,
                    'filters'=>array(
                        array('name'=>'StringTrim'),
                        array('name'=>'StripTags'),
//                        array('name'=>'Word\SeparatorToDash'), a b c = a-b-c
                    ),
                    'validators'=>array(
                        array(
                            'name'=>'StringLength',
                            'options'=>array(
                                'min' => '3',
                                'max' => '125',
                                'messages'=>array(
                                    'stringLengthTooShort' => 'Bạn Phải nhập nhiều hơn %min% ký tự',
                                    'stringLengthTooLong' => 'Phải ít hơn %max% ký tự',
                                ),
                            ),
                        ),
                        array(
                            'name' => 'Digits',
                            'options' =>array(
                                'messages'=>array(
                                    'notDigits'=> 'ký tự nhập vào phải là số',
                                ),
                            ),
                        ),
                    ),
                )
             );
    }

}
