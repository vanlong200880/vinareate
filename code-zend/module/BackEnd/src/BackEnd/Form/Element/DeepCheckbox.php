<?php
namespace BackEnd\Form\Element;

use Zend\Form\Element;

class DeepCheckbox extends Element{
    protected $checkboxes;

    public function setCheckboxes($checkboxes){
        if($this->value){
            foreach($checkboxes as $item){
                foreach($this->value as $key => $checkedId){
                    if($item["id"] == $checkedId){
                        $item["checked"] = true;
                        unset($this->value[$key]);
                    }
                }
            }
        }
        $this->checkboxes = $checkboxes;
    }

    public function getCheckboxes(){
        return $this->checkboxes;
    }
}