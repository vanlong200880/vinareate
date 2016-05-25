<?php
namespace BackEnd\Controller;

use BackEnd\Form\Element\DeepCheckbox;
use BackEnd\Form\PostFilter;
use BackEnd\Form\PostForm;
use BackEnd\Model\District;
use BackEnd\Model\Post;
use BackEnd\Model\PostFeature;
use BackEnd\Model\Province;
use BackEnd\Model\Ward;
use Zend\Form\Element;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceManager;
use Zend\Validator;
use Zend\View\Model\ViewModel;

/**
 * @warn
 * 1. checkbox can not save state with PostForm
 * (bcs it not a part of PostForm,
 * dynamicly created by postFeatures)
 */

/**
 * Class PostController
 * @package BackEnd\Controller
 */
class PostController extends DatabaseController{
    protected $serviceManager;

    /**
     * PostController constructor.
     * @param ServiceManager $sm
     */
    public function __construct($sm){
        parent::__construct($sm);
    }

    public function indexAction(){
        $new = new ViewModel();
        return $new;
    }

    /**
     * @return ViewModel
     */
    public function createAction(){
        $view = new ViewModel();
        //        $postFilter = new PostFilter();
        $postForm = new PostForm("post_form");
        //        $postForm->setInputFilter($postFilter);
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isGet()){

        }

        if($request->isPost()){
            $postParams = $request->getPost();
            var_dump($postParams);

            $post = new Post();

            $postFilter = new PostFilter();

            $postForm->setInputFilter($postFilter);
            $postForm->setData($postParams);

            /**
             * check valid for dynamic input
             */
            $isDigitValid = true;
            $digitValidMsg = "";
            $digitValidator = new  Validator\Digits();
            $digitValidator->setMessage("bạn phải nhập số tiền", Validator\Digits::STRING_EMPTY);
            $digitValidator->setMessage("chỉ nhập số, đơn vị tính VND", Validator\Digits::NOT_DIGITS);
            $taxHistory = $postParams->get("taxHistory");
            foreach($taxHistory as $record){
                if(!$digitValidator->isValid($record[0]) || !$digitValidator->isValid($record[1])){
                    $isDigitValid = false;
                    //only get the first one
                    $digitValidMsg = array_values($digitValidator->getMessages())[0];
                }
            }

            $view->setVariable("digitValidMsg", $digitValidMsg);

            /**
             * check valid of form
             */
            if($postForm->isValid() && $isDigitValid){
                /**
                 * for debug purpose
                 * dump data
                 */
                $post->category_id = 5;
                $post->user_id = 1;
                $post->post_status_id = 1;

                $post->fill((array)$postParams);
                $post->save();
                return $this->redirect()->toUrl("/");
            }

            /**
             * innject options for district-select
             */
            $provinceId = $postParams->get("provinceid");
            $ditricts = District::where("provinceid", $provinceId)->get();
            $districtOptions = array();
            foreach($ditricts as $item){
                $row = array();
                $row["value"] = $item["districtid"];
                $row["label"] = $item["name"];
                $districtOptions[] = $row;
            }
            /** @var Element\Select $districtSelect */
            $districtSelect = $postForm->get("districtid");
            $districtSelect->setEmptyOption(array(
                "label" => "--chọn tỉnh thành phố--",
                "disabled" => true,
                "selected" => true
            ));
            $districtSelect->setValueOptions($districtOptions);

            /**
             * inject options for ward-select
             */
            $districtId = $postParams->get("districtid");
            $wards = Ward::where("districtid", $districtId)->get();
            $wardOptions = array();
            foreach($wards as $item){
                $row = array();
                $row["value"] = $item["wardid"];
                $row["label"] = $item["name"];
                $wardOptions[] = $row;
            }
            /** @var Element\Select $wardSelect */
            $wardSelect = $postForm->get("wardid");
            $wardSelect->setEmptyOption(array(
                "label" => "--chọn tỉnh phường xã--",
                "disabled" => true,
                "selected" => true
            ));
            $wardSelect->setValueOptions($wardOptions);
        }
        /**
         * inject options for province-select
         */

        $provinces = Province::all();
        $provinceOptions = array();
        foreach($provinces as $item){
            $row = array();
            $row["value"] = $item["provinceid"];
            $row["label"] = $item["name"];
            $provinceOptions[] = $row;
        }
        /** @var Element\Select $proviceSelect */
        $proviceSelect = $postForm->get("provinceid");
        $proviceSelect->setValueOptions($provinceOptions);

        /**
         * inject checkbox for deep checkbox "feature"
         */
        $postFeatures = PostFeature::all();
        /** @var DeepCheckbox $deepFeature */
        $deepFeature = $postForm->get("deepFeature");
        /**
         * inject back checked feature (not a good solution),
         * when data injected by PostForm through "setData"
         */
        $deepFeature->setCheckboxes($postFeatures);

        $view->setVariable("postForm", $postForm);

        return $view;
    }


}