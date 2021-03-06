<?php
namespace BackEnd\Controller;

use BackEnd\Database\PostFeature;
use BackEnd\Module;
use BackEnd\Util\MessageUtil;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class PostFeatureController extends AbstractActionController{
    protected $serviceManager;
    protected $postFeature;
    protected $view;
    protected $msg = "";
    protected $msgUtil;

    const ITEMS_PER_PAGE = 5;

    private $info = "sorry, we still not handle this situation";

    public function __construct(ServiceManager $sm){
        /**
         * init serviceManager
         */
        $this->serviceManager = $sm;

        $this->postFeature = new PostFeature($this->serviceManager->get("adapter"));

        /**
         * init msgCtrl
         */
        /** @var Container $sessionError */
        $sessionError = $this->serviceManager->get("SessionError");
        $this->msgUtil = new MessageUtil($sessionError);

        /**
         * init view
         */
        $this->view = new ViewModel();

        /**
         * set layout
         */
        $this->layout()->setTemplate(Module::LAYOUT);
    }

    public function indexAction(){
        $this->msgUtil->show($this->layout());

        $pageId = $this->getEvent()->getRouteMatch()->getParam('page');

        $postFeatures = $this->postFeature->all();
        /**
         * handle paginator
         */
        $paginator = new Paginator(new ArrayAdapter($postFeatures));
        $paginator->setItemCountPerPage(self::ITEMS_PER_PAGE);
        $paginator->setCurrentPageNumber($pageId);

        //        $this->view->setVariable("postFeatures", $postFeatures);
        $this->view->setVariable("paginator", $paginator);
        return $this->view;
    }

    public function viewAction(){
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        $postFeature = $this->postFeature->get($postFeatureId);
        $this->view->setVariable("postFeature", $postFeature);
        return $this->view;
    }

    public function editAction(){
        $this->msgUtil->show($this->layout());

        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        /** @var Request $request */
        $request = $this->getRequest();
        if($request->isPost()){
            $postParams = $request->getPost();
            $result = $this->postFeature->update((array)$postParams, array("id" => $postFeatureId));
            $this->msgUtil->set($result["info"]);
            return $this->redirect()->toUrl("/backend/post-feature/" . $postFeatureId . "/edit");
        }
        if($request->isGet()){
            $postFeature = $this->postFeature->get($postFeatureId);
            $this->view->setVariable("postFeature", $postFeature);
        }
        return $this->view;
    }

    public function deleteAction(){
        $this->msgUtil->show($this->layout());

        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        $result = $this->postFeature->delete($postFeatureId);
        $this->msgUtil->set($result["info"]);
        $url = "/backend/post-feature";
        //$result is empty string
        if($result["status"]){
            $url .= "";
        }
        if(!$result["status"]){
            /**
             * they can not delete it
             * let them edit it if they want
             */
            $url .= "/" . $postFeatureId . "/edit";
        }
        return $this->redirect()->toUrl($url);
    }

    public function createAction(){
        $this->msgUtil->show($this->layout());
        /** @var Request $request */
        $request = $this->getRequest();
        if($request->isPost()){
            $postParams = $request->getPost();
            $result = $this->postFeature->insert((array)$postParams);
            $this->msgUtil->set($result["info"]);
            return $this->redirect()->toUrl("/backend/post-feature");
        }
        if($request->isGet()){
            return $this->view;
        }
        die($this->info);
    }

    public function deepFeatureAction(){
        $this->msgUtil->show($this->layout());
        $postFeatures = $this->postFeature->all();
        /**
         * do pagination
         */
        $this->view->setVariable("postFeatures", $postFeatures);
        return $this->view;
    }

    /**
     * decide where to go next
     * @return \Zend\Http\Response|ViewModel
     */
    public function deepFeatureMatchAction(){
        /** @var Request $request */
        $request = $this->getRequest();
        if($request->isPost()){
            $postParmas = $request->getPost();
            $featureId = $postParmas->get("featureId");
            $action = $postParmas->get("action");
            /**
             * handle 2 cases on "featureId"
             * 1. has children > /deep-feature/{id}
             * 2. is a single item > /post-feature/{id}
             */
            $url = "";
            /**
             * handle 2 cases on "action"
             * 1. edit
             * 2. delete
             */
            if($action === "edit"){
                $url .= "/backend/post-feature/" . $featureId . "/edit";
            }
            if($action === "delete"){
                $url .= "/backend/deep-feature/" . $featureId . "/delete";
            }
            return $this->redirect()->toUrl($url);

        }
        die($this->info);
    }

    /**
     * unused, bcs 1. edit directly/ 2. single edit
     * edit this way like loop again
     * @return ViewModel
     */
    public function deepFeatureEditAction(){
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');
        $feature = $this->postFeature->get($postFeatureId);
        $children = $this->postFeature->getChildren($postFeatureId);
        $this->view->setVariable("feature", $feature);
        $this->view->setVariable("children", $children);
        return $this->view;
    }

    /**
     * delete on a group (DEEP)
     * @return \Zend\Http\Response
     */
    public function deepFeatureDeleteAction(){
        $postFeatureId = $this->getEvent()->getRouteMatch()->getParam('id');

        $result = $this->postFeature->deepDelete($postFeatureId);
        $this->msgUtil->set($result["info"]);

        return $this->redirect()->toUrl("/backend/deep-feature");
    }

    public function testAction(){
        $postFeatures = $this->postFeature->all();
        $this->view->setVariable("postFeatures", $postFeatures);
        return $this->view;
    }

}