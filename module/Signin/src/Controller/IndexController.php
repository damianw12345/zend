<?php
/**
 * Created by PhpStorm.
 * User: ja
 * Date: 08.08.2016
 * Time: 20:54
 */

namespace Signin\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $session = new Container('user_ses');
        if ($session->logged)
        {
            return ['login' => $session->username];
        }
        else
        {
            return $this->redirect()->toRoute('signin');
        }
        return [];
    }

}