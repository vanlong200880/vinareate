<?php
namespace BackEnd\Controller;

use BackEnd\Model\Comment;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

class TestController extends AbstractActionController{
    protected $sm;
    /**
     * TestController constructor.
     * @param ServiceManager $sm
     */
    public function __construct($sm){
        $this->sm = $sm;
        $this->sm->get("init-capsule");
    }

    public function indexAction(){
//        new PHPRenderer();
        $view = new ViewModel();
        $view->setVariable("config", $this->sm->get("config"));
        return $view;
    }

    public function userCommentAction(){
        $view = new ViewModel();

        $postId = 1;
        $commentUser = Comment::with("user")->where("post_id", $postId)->get();
//        $commentUser = Comment::with("user")->where("post_id", $postId)->get();
//        $rating = Rating::where("post_id", $postId)->first();

//        $view->setVariable("rating", $rating);
        $view->setVariable("commentUser", $commentUser);
//        $view->setVariable("commentUser", $commentUser);
        return $view;
    }
}