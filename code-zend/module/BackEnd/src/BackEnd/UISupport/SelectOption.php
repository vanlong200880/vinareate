<?php
namespace BackEnd\UISupport;
class SelectOption{

    /**
     * return options for Zend\Form\Element\Select
     * @param $itemsCollection
     * @return array
     */
    public static function zendFormSelectOptions($itemsCollection){
        $r = array();
        foreach($itemsCollection as $item){
            $row = array();
            $row["value"] = $item["id"];
            $row["label"] = $item["name"];
            $r[] = $row;
        }
        return $r;
    }
}