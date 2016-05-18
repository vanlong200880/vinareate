<?php
namespace BackEnd\Controller;

use BackEnd\Model\PostFeature;
use BackEnd\Model\PostFeatureDetail;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class IlluminateDatabaseController extends AbstractActionController{
    public function __construct(){
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'vinarealtor',
            'username' => 'root',
            'password' => 'ifrc',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        // Set the event dispatcher used by Eloquent models... (optional)
        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }

    public function indexAction(){
        $view = new ViewModel();

        /**
         * simple query on table PostFeatureDetail
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
        return $view;

    }
}