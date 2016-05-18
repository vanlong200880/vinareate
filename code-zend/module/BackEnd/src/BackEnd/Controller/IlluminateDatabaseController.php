<?php
namespace BackEnd\Controller;

use BackEnd\Model\PostFeature;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\ViewModel;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class IlluminateDatabaseController extends AbstractActionController{
    public function __construct(){
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'vinarealtor',
            'username'  => 'root',
            'password'  => 'ifrc',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
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
//        $postFeature = PostFeature::where("id", "=", 1)->get();
        $postFeature = PostFeature::find(1);
//        $postFeature = Capsule::table('post_features')->where('id', '=', 1)->get();

        $view->setVariable("postFeature", $postFeature);
        return $view;

    }
}