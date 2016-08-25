<?php
/**
 * Created by PhpStorm.
 * User: ja
 * Date: 08.08.2016
 * Time: 20:54
 */

namespace Signin\Controller;


use Zend\Db\TableGateway\Exception\RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\JsonRenderer;
use Zend\View\View;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $session = new Container('user_ses');
        if ($session->logged)
        {
//            return ['login' => $session->username];

            $viewmodel = new ViewModel();

            throw new RuntimeException(
                sprintf($viewmodel->getTemplate())
            );

            return new JsonModel([
                'success' => false,
                'html' => '<label id="tesst">'.$login.'pała'.'</label>',
            ]);

        }
        else
        {
            return $this->redirect()->toRoute('signin');
        }
        return [];
    }

}