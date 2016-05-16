<?php
namespace FrontEnd\Controller;

use FrontEnd\Database\HousePosition;
use FrontEnd\Database\Post;
use FrontEnd\Database\PostContact;
use FrontEnd\Database\PostFeatureDetail;
use FrontEnd\Database\PostImage;
use FrontEnd\Database\PostTaxHistory;
use FrontEnd\UIObject\PostTabView;
use Zend\Db\Adapter\Adapter;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController{
    protected $serviceManager;
    protected $placeQuery;
    protected $postTabView;

    /**
     * PostController constructor.
     * @param ServiceManager $sm
     */
    public function __construct($sm){
        $this->serviceManager = $sm;

        $configDb = $this->serviceManager->get('config')["db"];
        $adapter = new Adapter($configDb);
        $this->placeQuery = new HousePosition($adapter);

        $this->postTabView = new PostTabView();
    }

    public function indexAction(){
        $view = new ViewModel();
        return $view;
    }

    public function tabAction(){
        $view = new ViewModel();

        /**
         * get province data from database
         */
        //        $configDb = $this->serviceManager->get('config')["db"];
        //        $adapter = new Adapter($configDb);
        //        $adapter = $this->serviceManager->get("adapter");
        //        $placeQuery = new PlaceQuery($adapter);

        $provinces = $this->placeQuery->getProvinces();
        $uiProvinces = $this->postTabView->getProvincesOption($provinces);
        $view->setVariable('provinces', $uiProvinces);
        return $view;
    }

    /**
     * only handle post method
     * return district base on provinceid
     */
    public function districtAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $postParams = $request->getPost();
            $provinceid = json_decode($postParams->get("provinceid"), true);

            $districts = $this->placeQuery->getDistrictOnProvinceId($provinceid);
            $uiDistricts = $this->postTabView->getDistrictsOption($districts);
            $view->setVariable("districts", $uiDistricts);

            return $view;
        }
        die("not handle request GET");
    }

    public function wardAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $postParams = $request->getPost();
            $wardid = json_decode($postParams->get("districtid"), true);

            $wards = $this->placeQuery->getWardOnDistrictId($wardid);
            $uiWards = $this->postTabView->getWardsOption($wards);
            $view->setVariable("wards", $uiWards);

            return $view;
        }
        die("not handle request GET");
    }

    public function parentCategoryAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            //            $postParams = $request->getPost();

            $parentCategories = $this->placeQuery->getParentCategory();
            $uiParentCategories = $this->postTabView->getParentCategoryOption($parentCategories);
            $view->setVariable("parentCategory", $uiParentCategories);

            return $view;
        }
        die("not handle request GET");
    }

    public function categoryAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $postParams = $request->getPost();
            $parentCategoryId = json_decode($postParams->get("parentCategoryId"), true);

            $categories = $this->placeQuery->getCategory($parentCategoryId);
            $uiCategories = $this->postTabView->getCategoryOption($categories);
            $view->setVariable("category", $uiCategories);
            return $view;
        }
        die("not handle request GET");
    }

    public function featureAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $features = $this->placeQuery->getAllFeatures();
            //            $uiCategories = $this->postTabView->getCategoryOption($categories);
            $view->setVariable("features", $features);
            return $view;
        }
        die("not handle request GET");
    }

    public function savePostAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $postParams = $request->getPost();

            $step1 = $postParams->get("step1");
            $step1Data = json_decode($step1, true);

            $step2 = $postParams->get("step2");
            $step2Data = json_decode($step2, true);

            $step3 = $postParams->get("step3");
            $step3Data = json_decode($step3, true);

            $step4 = $postParams->get("step4");
            $step4Data = json_decode($step4, true);

            $step5 = $postParams->get("step5");
            $step5Data = json_decode($step5, true);


            /**
             * handle insert to database
             */
            //hard code to insert demo ^^
            $userId = 1;
            $postStatusId = 1;
            $post = new Post($this->serviceManager->get("adapter"));

            //step1
            $step1Columns = array(
                "provinceid",
                "districtid",
                "wardid",
                "house_number",
                "street",
                "zip_code",
                "category_id",
                "user_id",
                "post_status_id"
            );
            $step1Values = array(
                $step1Data["province"],
                $step1Data["district"],
                $step1Data["ward"],
                $step1Data["house"],
                $step1Data["street"],
                $step1Data["zipCode"],
                $step1Data["category"],
                $userId,
                $postStatusId
            );
            $postId = 1; //for debug purpose
            $postId = $post->insert($step1Columns, $step1Values);

            //step2
            $postContact = new PostContact($this->serviceManager->get("adapter"));
            //map post --- post_contact, at the end of column post_id
            $step2Columns = array(
                "fullname",
                "company",
                "email",
                "phone",
                "post_id"
            );
            $step2Values = array(
                $step2Data["fullName"],
                $step2Data["companyName"],
                $step2Data["email"],
                $step2Data["phone"],
                $postId
            );
            $postContact->insert($step2Columns, $step2Values);

            //step3
            $step3Columns = array(
                "price",
                "price_installment",
                "bed_rooms",
                "living_rooms",
                "dining_rooms",
                "office_rooms",
                "worship_rooms",
                "entertainment_rooms",
                "balcony",
                "floors",
                "build_year",
                "area_use",
                "direction"
            );
            $step3Values = array(
                $step3Data["housePrice"],
                $step3Data["housePriceInstallment"],
                $step3Data["bedRooms"],
                $step3Data["livingRooms"],
                $step3Data["diningRooms"],
                $step3Data["officeRooms"],
                $step3Data["worshipRooms"],
                $step3Data["entertainmentRooms"],
                $step3Data["balcony"],
                $step3Data["floors"],
                $step3Data["buildYear"],
                $step3Data["houseArea"],
                $step3Data["houseDirection"]
            );
            $step3SetColumnValue = array_combine($step3Columns, $step3Values);
            $post->update($step3SetColumnValue, array("id" => $postId));

            //step 4
            //only insert when it set
            if($step4Data["youtubeUrl"] != ""){
                $step4VideoId = $step4Data["embedCode"];
                $post->update(array("video" => $step4VideoId), array("id" => $postId));
            }


            //step5
            $step5Columns = array(
                "name",
                "excerpt",
                "content",
                "website"
            );
            $step5Values = array(
                $step5Data["postTitle"],
                $step5Data["postExcerpt"],
                $step5Data["postContent"],
                $step5Data["website"]
            );
            $step5SetColumnValue = array_combine($step5Columns, $step5Values);
            $post->update($step5SetColumnValue, array("id" => $postId));

            /**
             * handle specical case
             * 1. Tax History
             * 2. Feature
             */
            /**
             * 1. Tax History
             */
            $postTaxHistory = new PostTaxHistory($this->serviceManager->get("adapter"));
            $postTaxHistoryColumns = array(
                "year",
                "area",
                "price",
                "post_id"
            );
            foreach($step3Data["taxHistory"] as $postTaxHistoryValues){
                array_push($postTaxHistoryValues, $postId);
                $postTaxHistory->insert($postTaxHistoryColumns, $postTaxHistoryValues);
            }
            /**
             * 2. Feature
             */
            $postFeatureDetail = new PostFeatureDetail($this->serviceManager->get("adapter"));
            $postFeatureDetailColumns = array(
                "post_id",
                "post_features_id"
            );
            foreach((array)$step5Data["panelGroupFeature"] as $featureGroup){
                if(is_array($featureGroup) && (count($featureGroup) > 0)){
                    foreach($featureGroup as $featureId){
                        $postFeatureDetailValues = array(
                            $postId,
                            $featureId
                        );
                        $postFeatureDetail->insert($postFeatureDetailColumns, $postFeatureDetailValues);
                    }
                }
            }
            /**
             * handle image uploaded
             * base on file name > where tmp file
             * move tmp file to public/images/user_id/post_id
             * hanlde by UploadClass
             */
            //            $files = $_FILES;
            //            $files = array();

            $view->setVariable("savePost", array(
                "userId" => $userId,
                "postId" => $postId
            ));
            return $view;
        }
        die("not handle request GET");
    }

    public function uploadImageAction(){
        /** @var Request $request */
        $request = $this->getRequest();

        if($request->isPost()){
            $view = new JsonModel();

            $postParams = $request->getPost();
            $postInfo = json_decode($postParams->get("postInfo"), true);
            $userId = $postInfo["userId"];
            $postId = $postInfo["postId"];

            $ret = $this->saveImage($userId, $postId);

            $view->setVariable("uploadImage", $ret);
            return $view;
        }
        die("not handle request GET");
    }

    private function saveImage($userId, $postId){
        $postImage = new PostImage($this->serviceManager->get("adapter"));
        $postImageColumns = array(
            "name",
            "type",
            "size",
            "path",
            "post_id"
        );
        $postImageValues = array();
        /**
         * hanlde make directory
         * bcs $userId / $postId not exist
         * only data/images exist
         */
        $outputDir = "data/images/" . $userId . "/" . $postId . "/";
        if(!mkdir($outputDir, 0700)){
            mkdir($outputDir, 0700);
        }
        $inputFileName = "uploadImage";
        $ret = array();
        if(isset($_FILES[$inputFileName])){
            $files = $this->diverse_array($_FILES[$inputFileName]);
            foreach($files as $file){
                $fileName = $file["name"];
                move_uploaded_file($file["tmp_name"], $outputDir . $fileName);
                $postImageValues[] = $fileName;
                $postImageValues[] = $file["type"];
                $postImageValues[] = $file["size"];
                $postImageValues[] = $outputDir . $fileName;
                $postImageValues[] = $postId;
                $ret[] = $fileName;
                $postImage->insert($postImageColumns, $postImageValues);
            }
            //            if(!is_array($files["name"])){
            //                $fileName = $files["name"];
            //                move_uploaded_file($files["tmp_name"], $outputDir . $fileName);
            //                $postImageValues[] = $fileName;
            //                $postImageValues[] = $files["type"];
            //                $postImageValues[] = $files["size"];
            //                $postImageValues[] = $outputDir . $fileName;
            //                $postImageValues[] = $postId;
            //                $ret[] = $fileName;
            //                $postImage->insert($postImageColumns, $postImageValues);
            //            }else{
            //                $fileCount = count($files["name"]);
            //                for($i = 0; $i < $fileCount; $i++){
            //                    $fileName = $files["name"][$i];
            //                    move_uploaded_file($files["tmp_name"][$i], $outputDir . $fileName);
            //                    $postImageValues[] = $fileName;
            //                    $postImageValues[] = $files["type"][$i];
            //                    $postImageValues[] = $files["size"][$i];
            //                    $postImageValues[] = $outputDir . $fileName;
            //                    $postImageValues[] = $postId;
            //                    $postImage->insert($postImageColumns, $postImageValues);
            //                    $ret[] = $fileName;
            //                }
            //
            //            }
        }
        return $ret;
    }

    private function diverse_array($vector){
        $result = array();
        foreach($vector as $key1 => $value1){
            foreach($value1 as $key2 => $value2){
                $result[$key2][$key1] = $value2;
            }
        }
        return $result;
    }
}