<?php
namespace BackEnd\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PostForm extends Form{
    public function __construct($name){
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        $this->setAttribute('autocomplete', 'off');

//        $this->add(array(
//            'type' => 'Zend\Form\Element\Csrf',
//            'name' => 'loginCsrf',
//            'options' => array(
//                'csrf_options' => array(
//                    'timeout' => 3600
//                )
//            )
//        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'class' => 'btn btn-success form-control'
            )
        ));

        $this->add(array(
            'name' => 'house_number',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'nhập số nhà',
            )
        ));

        $this->add(array(
            'name' => 'street',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'nhập tên đường',
            )
        ));

        $this->add(array(
            'name' => 'zip_code',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'mã zip/code',
            )
        ));

        $this->add(array(
            'name' => 'fullname',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'họ và tên',
            )
        ));


        $this->add(array(
            'name' => 'company',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'tên công ty',
            )
        ));


        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'email',
            )
        ));

        $this->add(array(
            'name' => 'phone',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'số điện thoại',
            )
        ));

        $this->add(array(
            'name' => 'price',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'giá bán',
            )
        ));

        $this->add(array(
            'name' => 'price_installment',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'giá theo tháng',
            )
        ));

        $this->add(array(
            'name' => 'area_use',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'diện tích sử dụng',
            )
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'tiêu đề',
            )
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'tiêu đề',
            )
        ));

        $this->add(array(
            'name' => 'excerpt',
            'type' => 'textarea',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'mô tả ngắn',
            )
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'textarea',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'nội dung',
            )
        ));

        $this->add(array(
            'name' => 'website',
            'type' => 'text',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'website',
            )
        ));

        $this->add(array(
            'type' => Element\Select::class,
            'name' => 'provinceid',
            'attributes' =>  array(
                'id' => "provinceSelect",
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Chọn thành phố',
            ),
        ));

        $this->add(array(
            'type' => Element\Select::class,
            'name' => 'districtid',
            'attributes' =>  array(
                'id' => "districtSelect",
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Chọn quận huyện',
            ),
        ));
        $this->add(array(
            'type' => Element\Select::class,
            'name' => 'wardid',
            'attributes' =>  array(
                'id' => "wardSelect",
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Chọn phường xã',
            ),
        ));

    }
}