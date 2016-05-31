<?php
namespace BackEnd\Controller;

use BackEnd\Model\Category;
use BackEnd\Model\Post;
use BackEnd\Model\PostFeature;
use BackEnd\Model\PostFeatureDetail;
use BackEnd\Model\Province;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Illuminate\Database\Query;
use Illuminate\Database\Capsule\Manager as Capsule;

class IlluminateDatabaseController extends AbstractActionController{
    protected $serviceManager;

    public function __construct(ServiceManager $sm){
        $this->serviceManager = $sm;
//        $capsule = new Capsule;
//
//        $capsule->addConnection([
//            'driver' => 'mysql',
//            'host' => 'localhost',
//            'database' => 'vinarealtor',
//            'username' => 'root',
//            'password' => 'ifrc',
//            'charset' => 'utf8',
//            'collation' => 'utf8_unicode_ci',
//            'prefix' => '',
//        ]);
//
//        // Set the event dispatcher used by Eloquent models... (optional)
//        $capsule->setEventDispatcher(new Dispatcher(new Container));
//
//        // Make this Capsule instance available globally via static methods... (optional)
//        $capsule->setAsGlobal();
//
//        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
//        $capsule->bootEloquent();

        $this->serviceManager->get("init-capsule");
    }

    public function indexAction(){
        $view = new ViewModel();

        /**
         * simple with on table PostFeatureDetail
         * instead of self-code on SELECT
         * extends Eloquent\Model
         * access row by find/get
         */
        $detail2 = PostFeatureDetail::find(2);
        /**
         * relations, PostFeatureDetail, map post-feature
         * like JOIN table, after get out id=1,
         * get out feature map with
         */
        $postFeatureDetail = PostFeatureDetail::with("feature")->find(1);

        $view->setVariable("postFeatureDetail", $postFeatureDetail);
        $view->setVariable("detail2", $detail2);
//        return $view;

        $jsonModel = new JsonModel();

//        $with = Post::where("id", "in", function($with){
//            $with->select("post_id")
//                ->from("post_feature_detail")
//                ->where("id", "<", 10);
//        });
//        var_dump($with->getQuery());

//        $subQuery = Capsule::table("post_feature_detail")->where("id", "<", 10);
//        var_dump($subQuery->toSql());

        $provinces = Province::whereIn('provinceid', function($query){
            $query->select('post_id')->from((new PostFeatureDetail())->getTable())->whereIn('post_features_id', [
                6,
                7,
                8
            ])->where("id", "<", 4);
        })->get();

        $jsonModel->setVariable("a", $provinces);

//        $provinces2 = Province::from(function($with){
//            $with->select("name")
//                ->from(with(new Province)->getTable())
//                ->limit(10)
//                ->offset(5)
//                ->as("T");
//        })->orderBy("name", "ASC")->get();
//
//        $jsonModel->setVariable("b", $provinces2);

        $deepFeatures = PostFeature::with("feature")->get();

        var_dump($deepFeatures);

        foreach($deepFeatures as $parentFeature){
            var_dump("[+]" . $parentFeature->name);
            $items = $parentFeature->feature;
            foreach($items as $item){
                var_dump("[--]" . $item->name);
//                var_dump($item->name);
            }
        }

        $deepCategories = Category::with("category")->get();

        foreach($deepCategories as $parentCategory){
            var_dump("[+]" . $parentCategory->name);
            $items = $parentCategory->category;
            foreach($items as $item){
                var_dump("[--]" . $item->name);
            }
        }

//        return $jsonModel;

//        $withQuery = PostFeatureDetail::with("feature")->where("id", "<", 3)->get();
//        $withQuery = PostFeatureDetail::with(array(
//            "feature" => function(Relation $hasMany){
////                var_dump($hasMany->getQuery()->toSql());
//                $query = $hasMany->getQuery();
//                $query->select("*");
//                $query->where("id", ">", 6);
//                var_dump($query->toSql());
////                return $query;
//            }
//        ))->where("id", "<", 3)->get();
////        var_dump($withQuery);
//        foreach($withQuery as $with){
//            $name = "null";
////            var_dump($with->feature->first());
//            if($with->feature->first()){
//                $name = $with->feature->first()->name;
//            }
//            var_dump($name);
////            var_dump($with->featureX->name);
////            var_dump($with->featureX->first());
////            var_dump($with->featureX->getAttributes());
////            var_dump($with->post_id, $with->id, $with->feature->first());
////            var_dump($with->feature->first()->name);
//        }

        return new ViewModel();
    }
}