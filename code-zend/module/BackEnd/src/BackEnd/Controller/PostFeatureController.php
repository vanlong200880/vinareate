<?php
namespace BackEnd\Controller;

use BackEnd\Database\PostFeature;
use BackEnd\Module;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class PostFeatureController extends AbstractActionController{
    protected $serviceManager;
    protected $postFeature;
    /** @var Container $sessionError */
    protected $sessionError;
    protected $view;
    protected $msg = "";
    protected $msgCtrl;

    public function __construct(ServiceManager $sm){
        $this->serviceManager = $sm;
        $this->postFeature = new PostFeature($this->serviceManager->get("adapter"));
        $this->layout()->setTemplate(Module::LAYOUT);
        $this->sessionError = $this->serviceManager->get("SessionError");
        $this->view = new ViewModel();
        $this->view->setVariable("msg", $this->msg);
        $this->layout()->setVariable("msg", $this->msg);
        if($this->sessionError->offsetExists("msg")){
            $this->view->setVariable("msg", $this->sessionError->msg);
            $this->layout()->setVariable("msg", $this->sessionError->msg);
        }
        $this->msgCtrl = new MessageController($this->serviceManager->get("SessionError"));
    }

    public function indexAction(){
        //        $view = new ViewModel();
        $postFeatures = $this->postFeature->all();

        //        $view->setVariable("postFeatures", $postFeatures);
        $this->view->setVariable("postFeatures", $postFeatures);
        //        return $view;
        return $this->view;
    }

    public function viewAction(){
        //        $view = new ViewModel();
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        /** @var Request $request */
        //        $request = $this->getRequest();
        //            var_dump("view action GET");
        $postFeature = $this->postFeature->get($postFeatureId);
        //        $view->setVariable("postFeature", $postFeature);
        $this->view->setVariable("postFeature", $postFeature);
        //        return $view;
        return $this->view;
    }

    public function editAction(){
        //        $view = new ViewModel();
        //set default msg
        //        $view->setVariable("msg", "");
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        /** @var Request $request */
        $request = $this->getRequest();
        if($request->isPost()){
            $postParams = $request->getPost();
            //            $postFeatureColumns = array(
            //                "name",
            //                "description",
            //                "menu_order",
            //                "parent",
            //                "status"
            //            );
            //            $postFeatureValues = array();
            //            $postFeature["name"] = $postParams["name"];
            //            $postFeature["description"] = $postParams["description"];
            //            $postFeature["menu_order"] = $postParams["menu_order"];
            //            $postFeature["parent"] = $postParams["parent"];
            //            $postFeature["status"] = $postParams["status"];
            //            $postFeatureSetColumnValue = array_combine($postFeatureColumns, $postFeatureValues);
            //            $this->postFeature->verifyInsertParams($postParams);
            $this->postFeature->update((array)$postParams, array("id" => $postFeatureId));

            return $this->redirect()->toUrl("/backend/post-feature/" . $postFeatureId . "/edit");
            //            return $this->redirect()->toRoute("post-feature-edit");
        }
        if($request->isGet()){
            $postFeature = $this->postFeature->get($postFeatureId);
            if($this->sessionError->offsetExists("msg")){
                //                $view->setVariable("msg", $this->sessionError->msg);
//                $this->view->setVariable("msg", $this->sessionError->msg);
//                $this->sessionError->offsetUnset("msg");
//                $this->msgCtrl->setSessionError()
            }
            //            $view->setVariable("postFeature", $postFeature);
            $this->view->setVariable("postFeature", $postFeature);
        }
        //        return $view;
        return $this->view;
    }

    public function deleteAction(){
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        $result = $this->postFeature->delete($postFeatureId);
        if($result){
//            $this->sessionError->msg = sprintf("%s deleted", $postFeatureId);
            $this->msgCtrl->setSessionError(sprintf("%s deleted", $postFeatureId));
            return $this->redirect()->toUrl("/backend/post-feature");
        }
        if(!$result){
            //            var_dump("foreign key, map post-feature");
            $this->sessionError->msg = "foreign key, map post-feature\ndelete on parent of others @@";
            return $this->redirect()->toUrl("/backend/post-feature/" . $postFeatureId . "/edit");
        }
        die("sorry we still not handle this situation");
    }

    public function createAction(){
        //        $view = new ViewModel();
        /** @var Request $request */
        $request = $this->getRequest();
        if($request->isPost()){
            $postParams = $request->getPost();
            //            $this->postFeature->verifyInsertParams($postParams);
            $this->postFeature->insert((array)$postParams);
            return $this->redirect()->toUrl("/backend/post-feature");
        }
        if($request->isGet()){
            //            return $view;
            return $this->view;
        }
        die("sorry we still not handle this situation");
    }

    public function deepFeatureAction(){
        //        $view = new ViewModel();
        $postFeatures = $this->postFeature->all();
        //        $view->setVariable("postFeatures", $postFeatures);
        $this->view->setVariable("postFeatures", $postFeatures);
        //        return $view;
        return $this->view;
    }

    /**
     * decide where to go next
     * @return \Zend\Http\Response|ViewModel
     */
    public function deepFeatureMatchAction(){
        //        $view = new ViewModel();
        /** @var Request $request */
        $request = $this->getRequest();
        //        if($request)
        if($request->isPost()){
            $postParmas = $request->getPost();
            $featureId = $postParmas->get("featureId");
            $action = $postParmas->get("action");
            /**
             * handel 2 case
             * 1. has children > /deep-feature/{id}
             * 2. is a single item > /post-feature/{id}
             */
            $children = $this->postFeature->getChildren($featureId);
            $url = "";
            if(count($children) > 0){
                $url .= "/backend/deep-feature/" . $featureId;
            }
            if(count($children) === 0){
                $url .= "/backend/post-feature/" . $featureId;
            }
            if($action === "edit"){
                $url .= "/edit";
            }
            if($action === "delete"){
                $url .= "/delete";
            }
            return $this->redirect()->toUrl($url);

        }
        //        return $view;
        return $this->view;
    }

    public function deepFeatureEditAction(){
        //        $view = new ViewModel();
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        /** @var Request $request */
        $request = $this->getRequest();
        //        if($request)
        if($request->isPost()){
        }
        if($request->isGet()){
            $feature = $this->postFeature->get($postFeatureId);
            $children = $this->postFeature->getChildren($postFeatureId);
            //            $view->setVariable("feature", $feature);
            $this->view->setVariable("feature", $feature);
            //            $view->setVariable("children", $children);
            $this->view->setVariable("children", $children);
        }
        //        return $view;
        return $this->view;
    }

    public function deepFeatureDeleteAction(){
        //        $view = new ViewModel();
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        $result = $this->postFeature->deepDelete($postFeatureId);
        $this->sessionError->msg = $result;
        return $this->redirect()->toUrl("/backend/deep-feature/");
    }

    public function testAction(){
        //        $view = new ViewModel();
        $postFeatures = $this->postFeature->all();
        //        $view->setVariable("postFeatures", $postFeatures);
        $this->view->setVariable("postFeatures", $postFeatures);
        //        return $view;
        return $this->view;
    }

}