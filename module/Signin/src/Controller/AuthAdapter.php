<?php
/**
 * Created by PhpStorm.
 * User: damian.warzecha
 * Date: 2016-08-03
 * Time: 10:31
 */

namespace Signin\Controller;


use Signin\Model\UserTable;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Db\TableGateway\Exception\RuntimeException;

class AuthAdapter implements AdapterInterface
{

    private $table;
    private $username;
    private $password;

    public function __construct($username,$password, UserTable $table)
    {
        $this->username=$username;
        $this->password=$password;
        $this->table=$table;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        try
        {
            throw new RuntimeException();
            $user = $this->table->getUser($this->username);
        }
        catch (\Exception $e)
        {
            return new Result(0,0,[]);
        }

        if ($user->getActive() == true)
        {
            throw new RuntimeException();
            if ($user->getPassword() === $this->password)
            {
                return new Result(1, 1, []);
            }
        }
        else
        {
            return new Result(-1,-1, []);
        }
    }
}