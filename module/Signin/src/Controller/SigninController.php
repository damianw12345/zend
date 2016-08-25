<?php

namespace Signin\Controller;

use Signin\Form\RegisterForm;
use Signin\Form\SigninForm;
use Signin\Model\User;
use Signin\Model\UserTable;
use Zend\Authentication\AuthenticationService;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;


class SigninController extends AbstractActionController
{
    private $table;
    private $smtp;
    public function __construct(UserTable $table, Smtp $smtp)
    {
        $this->table = $table;
        $this->smtp = $smtp;
    }

    /**
     * Kontroler logowania
     */
    public function signinAction()
    {
        /**
         * Tworze formularz logowania
         */
        $form = new SigninForm();
        $register_form = new RegisterForm();
        /**
         * Tworzony nowy kontener sesji
         */
        $session = new Container('user_ses');
        /**
         * Sprawdzenie czy użytkownik jest zalogowany
         */
        $this->checkSession();
        /**
         * Jeśli formularz został wysłany sprawdzamy parametry
         */
        if($this->getRequest()->isPost())
        {

            $authAdapter = new AuthAdapter($this->getRequest()->getPost('login'), $this->getRequest()->getPost('pass'), $this->table);
            $auth = new AuthenticationService();
            $result=$auth->authenticate($authAdapter);
            if($result==1)
            {
                $session->logged = true;
                $session->username = $this->getRequest()->getPost('login');
                $this->redirect()->toRoute('index');
            }
        }
        return [
            'form' => $form->init(),
            'register_form' => $register_form->init(),
            'logged' => $session->logged
        ];
    }

//    public function indexAction()
//    {
//        $session = new Container('user_ses');
//        if ($session->logged)
//        {
//            return ['login' => $session->username];
//        }
//        else
//        {
//            return $this->redirect()->toRoute('signin');
//        }
//        return [];
//    }

    public function logoutAction()
    {
        $session = new Container('user_ses');
        $session->getManager()->destroy();
        return $this->redirect()->toRoute('signin');
    }


    public function registrationAction()
    {

        $email = $this->params()->fromPost('email');
        $username = $this->params()->fromPost('login');
        $pass = $this->params()->fromPost('pass');

        $user = new User();
        $user->setEmail($this->params()->fromPost('email'));
        $user->setUsername($this->params()->fromPost('login'));
        $user->setPassword($this->params()->fromPost('pass'));
        $user->setUserId(0);

        if ( ($this->table->getUserByEmail($email) == null) && ($this->table->getUser($username) == null) )
        {
            $uniqid = $this->unigId();
            $user->setActive($uniqid);
            $this->table->saveUser($user);
            $message = new Message();
            $message->addTo($user->getEmail())
                ->addFrom('damianw12345@o2.pl')
                ->setSubject('Aktywacja konta')
                ->setBody('Link aktywacyjny: damren.pl:5422/active?id=' . $uniqid);

//            $options = new SmtpOptions([
//                'name' => 'o2',
//                'host' => 'poczta.o2.pl',
//                'connection_class' => 'login',
//                'connection_config' => [
//                    'username' => 'damianw12345',
//                    'password' => 'DupaWolowaISowa',
//                ],
//            ]);
//            $transport->send();
            $this->smtp->send($message);
        }

        return ['email' => $user->getActive()];
    }

    public function activeAction()
    {
        $user = $this->table->getUserByActive(
            $this->params()->fromQuery('id')
        );
        $user->setActive(true);
        $this->table->saveUser($user);


        return $this->redirect()->toRoute('signin');

//        return ['id' => $this->params()->fromQuery('id')];
    }

    public function ajaxAction()
    {
        $login = $this->params()->fromPost('user_name');

        if($this->table->getUser($login)==null)
        {
            return new JsonModel([
                'success' => true,
            ]);
        }



//        throw new RuntimeException();

        return new JsonModel([
            'success' => false,
            'html' => '<label id="tesst">'.$login.'pała'.'</label>',
        ]);
    }

    /**
     * Sprawdzenie czy user jest zalogowany
     */
    public function checkSession()
    {
        $session = new Container('user_ses');
        if ($session->logged)
        {
            return $this->redirect()->toRoute('index');
        }
    }

    public function unigId()
    {
        $uniqid='';
        for ($i=0;$i<57;$i++)
        {
            $uniqid = $uniqid . mt_rand(0,9);
        }
        return $uniqid;
    }


}

