<?php
namespace BackEnd\Form;

use BackEnd\Form\Element as CustomElement;
use Zend\Form\Element;
use Zend\Form\Form;

class PostForm extends Form{
    public function __construct($name){
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        $this->setAttribute('autocomplete', 'off');
        $this->setAttribute('enctype', 'multipart/form-data');

        //        $this->add(array(
        //            'type' => Element\Csrf::class,
        //            'name' => 'loginCsrf',
        //            'options' => array(
        //                'csrf_options' => array(
        //                    'timeout' => 3600
        //                )
        //            )
        //        ));

        $this->add(array(
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Save',
                'class' => 'btn btn-success form-control'
            )
        ));

        $this->add(array(
            'name' => 'house_number',
            'type' => Element\Text::class,
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'nhập số nhà',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'street',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'nhập tên đường',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'zip_code',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'mã zip/code',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'fullname',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'họ và tên',
            )
        ));


        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'company',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'tên công ty',
            )
        ));


        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'email',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'phone',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'số điện thoại',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'price',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'giá bán',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'price_installment',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'giá theo tháng',
            )
        ));

        $this->add(array(
            'type' => Element\Number::class,
            'name' => 'area_use',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'diện tích sử dụng',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'tiêu đề',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'tiêu đề',
            )
        ));

        $this->add(array(
            'type' => Element\Textarea::class,
            'name' => 'excerpt',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'mô tả ngắn',
            )
        ));

        $this->add(array(
            'type' => Element\Textarea::class,
            'name' => 'content',
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 4
            ),
            'options' => array(
                'label' => 'nội dung',
            )
        ));

        $this->add(array(
            'type' => Element\Text::class,
            'name' => 'website',
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
            'attributes' => array(
                'id' => "provinceSelect",
                'class' => 'form-control selectpicker',
            ),
            'options' => array(
                'label' => 'Chọn tỉnh thành',
                'disable_inarray_validator' => true,
                "empty_option" => "-- chọn tỉnh/thành --",
            ),
        ));

        $this->add(array(
            'type' => Element\Select::class,
            'name' => 'districtid',
            'attributes' => array(
                'id' => "districtSelect",
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Chọn quận huyện',
                'disable_inarray_validator' => true,
                "empty_option" => "-- chọn quận/huyện --",
            ),
        ));

        $this->add(array(
            'type' => Element\Select::class,
            'name' => 'wardid',
            'attributes' => array(
                'id' => "wardSelect",
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Chọn phường xã',
                'disable_inarray_validator' => true,
                "empty_option" => "-- chọn phường/xã --",
            ),
        ));

        $this->add(array(
            'type' => CustomElement\DeepCheckbox::class,
            'name' => 'deepFeature',
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'type' => CustomElement\DeepCheckbox::class,
            'name' => 'deepCategory',
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'type' => Element\Select::class,
            'name' => 'category_id',
            'attributes' => array(
                'id' => "categorySelect",
                'class' => 'form-control selectpicker',
            ),
            'options' => array(
                'label' => 'Chọn loại dự án',
                'disable_inarray_validator' => true,
                "empty_option" => "-- chọn loại dự án --",
            ),
        ));
    }
}