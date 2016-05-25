<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace BackEnd\View\Helper;

use BackEnd\Form\Element\DeepCheckbox;
use BackEnd\UISupport\MenuHierarchy;
use Exception;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Stdlib\ArrayUtils;

class FormDeepCheckbox extends AbstractHelper{

    protected $name;

    public function __invoke(DeepCheckbox $element = null){
        if(!$element instanceof DeepCheckbox){
            throw new Exception(sprintf("%s need %s", get_class($this), DeepCheckbox::class));
        }
        $this->render($element);
    }


    public function render(DeepCheckbox $element){
        $checkboxes = $element->getCheckboxes();
        $name = $element->getName() . "[]";
        $cbForeach = function($item) use ($name){
            echo '<label class="checkbox-inline"><input type="checkbox" name="' . $name . '" value="' . $item["id"] .
                '"';
            if(isset($item["checked"])){
                echo "checked";
            }
            echo ">";
            echo $item["name"];
            echo '</label>';
        };
        MenuHierarchy::show($checkboxes, 0, $cbForeach);
    }

}
