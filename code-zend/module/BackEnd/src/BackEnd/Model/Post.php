<?php
namespace BackEnd\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator;
use Zend\Form\Element;

class Post extends IlluminateModel implements InputFilterAwareInterface{
    protected $fillable = array(
        "name",
        "excerpt",
        "content",
        "price",
        "price_installment",
        "bed_rooms",
        "bath_rooms",
        "living_rooms",
        "dining_rooms",
        "office_rooms",
        "worship_rooms",
        "entertainment_rooms",
        "balcony",
        "floors",
        "build_year",
        "area_use",
        "area_real",
        "direction",
        "video",
        "created_at",
        "modify_date",
        "publish_date",
        "house_numbder",
        "street",
        "zip_code",
        "provinceid",
        "districtid",
        "wardid",
        "website",
        "menu_order",
        "category_id",
        "user_id",
        "post_status_id"
    );
    protected $table = "post";

    protected $inputFilter;

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter){
        // TODO: Implement setInputFilter() method.
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter(){
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();

            $filters = array(
                array(
                    'name' => 'StripTags'
                ),
                array(
                    'name' => 'StringTrim'
                )
            );

            $inputFilter->add(array(
                'name' => 'house_number',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập số nhà'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'street',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa tên đường'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'zip_code',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập mã zip code'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\Digits::class,
                        'options' => array(
                            'messages' => array(
                                Validator\Digits::NOT_DIGITS => 'mã zip code là số'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'fullname',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập mã zip code'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));


            $inputFilter->add(array(
                'name' => 'company',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập mã zip code'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));


            $inputFilter->add(array(
                'name' => 'email',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập email'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\EmailAddress::class,
                        'options' => array(
                            'messages' => array(
                                Validator\EmailAddress::INVALID_FORMAT => 'ví dụ: unimedia@gmail.com'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'phone',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập số điện thoại'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\StringLength::class,
                        'options' => array(
                            'min' => 8,
                            'messages' => array(
                                Validator\StringLength::TOO_SHORT => 'số điện thoại tối thiểu 8 chữ số'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'price',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập giá'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\Digits::class,
                        'options' => array(
                            'messages' => array(
                                Validator\Digits::NOT_DIGITS => 'bạn chỉ cần nhập số, đơn vị tính: VND'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'price_installment',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập giá theo tháng'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\Digits::class,
                        'options' => array(
                            'messages' => array(
                                Validator\Digits::NOT_DIGITS => 'bạn chỉ cần nhập số, đơn vị tính: VND'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'area_use',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập diện tích sử dụng'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\Digits::class,
                        'options' => array(
                            'messages' => array(
                                Validator\Digits::NOT_DIGITS => 'bạn chỉ cần nhập số, đơn vị tính: m2'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập diện tích sử dụng'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $inputFilter->add(array(
                'name' => 'excerpt',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập mô tả ngắn'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\StringLength::class,
                        'options' => array(
                            'min' => 20,
                            'messages' => array(
                                Validator\StringLength::TOO_SHORT => 'tối thiểu 20 kí tự'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),

                )
            ));

            $inputFilter->add(array(
                'name' => 'content',
                'required' => true,
                'filters' => $filters,
                'validators' => array(
                    array(
                        'name' => Validator\NotEmpty::class,
                        'options' => array(
                            'messages' => array(
                                Validator\NotEmpty::IS_EMPTY => 'bạn chưa nhập nội dung'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    array(
                        'name' => Validator\StringLength::class,
                        'options' => array(
                            'min' => 100,
                            'messages' => array(
                                Validator\StringLength::TOO_SHORT => 'tối thiểu 100 kí tự'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}