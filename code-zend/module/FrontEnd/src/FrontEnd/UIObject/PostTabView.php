<?php
namespace FrontEnd\UIObject;
class PostTabView{
    public function getProvincesOption($provinces){
        $arr = array();
        foreach($provinces as $province){
            $option = array();
            $option["val"] = $province["provinceid"];
            $option["html"] = sprintf("%s %s", $province["type"], $province["name"]);
            $arr[] = $option;
        }
        return $arr;
    }

    public function getDistrictsOption($districts){
        $arr = array();
        foreach($districts as $district){
            $option = array();
            $option["val"] = $district["districtid"];
            $option["html"] = sprintf("%s %s", $district["type"], $district["name"]);
            $arr[] = $option;
        }
        return $arr;
    }

    public function getWardsOption($wards){
        $arr = array();
        foreach($wards as $ward){
            $option = array();
            $option["val"] = $ward["wardid"];
            $option["html"] = sprintf("%s %s", $ward["type"], $ward["name"]);
            $arr[] = $option;
        }
        return $arr;
    }

    public function getParentCategoryOption($projectTypes){
        $arr = array();
        foreach($projectTypes as $projectType){
            $option = array();
            $option["val"] = $projectType["id"];
            $option["html"] = $projectType["name"];
            $arr[] = $option;
        }
        return $arr;
    }

    public function getCategoryOption($categories){
        $arr = array();
        foreach($categories as $category){
            $option = array();
            $option["val"] = $category["id"];
            $option["html"] = $category["name"];
            $arr[] = $option;
        }
        return $arr;
    }
}