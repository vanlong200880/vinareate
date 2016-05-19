<?php
namespace BackEnd\Controller;

use BackEnd\Form\LoginFilter;
use BackEnd\Form\LoginForm;
use BackEnd\Model\User;
use BackEnd\Service\Encrypt;
use BackEnd\Service\UniSession;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ParametersInterface;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController{
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager){
        $this->serviceManager = $serviceManager;
        $this->serviceManager->get("init-capsule");
    }

    /**
     * check login from user
     * @return ViewModel
     */
    public function loginAction(){
        $view = new ViewModel();
        /** @var Request $request */
        $request = $this->getRequest();

        $loginForm = new LoginForm("loginForm");
        $loginFilter = new LoginFilter();
        $loginForm->setInputFilter($loginFilter);

        if($request->isGet()){
            //no thing change
        }

        if($request->isPost()){
            /** @var ParametersInterface $data */
            $data = $request->getPost();

            $loginForm->setData($data);
            /*
             * validate by loginForm
             */
            if($loginForm->isValid()){

                /*
                 * check auth, right/wrong
                 */
                $email = $data->get('email');

                $user = User::where("email", $email)->first();

                if(!$user){
                    //do nothing
                }
                if($user){
                    $isRightPassword = false;
                    $encryptPass = Encrypt::hash($data->get('password'));
                    if($encryptPass === $user['salt']){
                        $isRightPassword = true;
                    }

                    if($isRightPassword){
                        $uniSession = new UniSession();
                        $uniSession->set(UniSession::USER, UniSession::USER_LOGGED, $user);
                        $this->redirect()->toUrl('/');
                    }
                }
            }
        }
        $view->setVariable("loginForm", $loginForm);
        return $view;
    }

    public function joinAction(){
        $view = new ViewModel();
        /** @var Request $request */
        $request = $this->getRequest();

        $loginForm = new LoginForm("loginForm");
        $loginFilter = new LoginFilter();
        $loginForm->setInputFilter($loginFilter);

        if($request->isGet()){
            //no thing change
        }

        if($request->isPost()){
            /** @var ParametersInterface $data */
            $data = $request->getPost();

            $loginForm->setData($data);

            if($loginForm->isValid()){

                $user = User::where("email", $data->get("email"))->first();
                if($user){
                    //do nothing
                }
                if(!$user){
                    $user = new User();
                    $user->email = $data->get("email");
                    $user->salt = Encrypt::hash($data->get("password"));
                    $result = $user->save();

                    if($result){
                        $uniSession = new UniSession();
                        $uniSession->set(UniSession::USER, UniSession::USER_LOGGED, $user);
                        $this->redirect()->toUrl("/");
                    }
                }

            }
        }
        $view->setVariable("loginForm", $loginForm);
        return $view;
    }

    public function logoutAction(){
        $uniSession = new UniSession();
        $uniSession->remove(UniSession::USER, UniSession::USER_LOGGED);
        return $this->redirect()->toUrl('/login');
    }
}