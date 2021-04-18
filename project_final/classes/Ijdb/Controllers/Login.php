<?php


namespace Ijdb\Controllers;


class Login
{
    private $authentication;

    public function __construct( \Ninja\Authentication $authentication){
        $this->authentication = $authentication;
    }

    public function error(){
        $title = 'You must log in';
        return ['title'=>$title,
            'template'=>'loginerror.html.php'];
    }
    public function permissionError(){
        $title = 'You do not have permission';
        return ['title'=>$title,
            'template'=>'permissionerror.html.php'];
    }
    public function loginForm(){
        return ['title'=>'Log in',
            'template'=>'login.html.php'];
    }
    public function processLogin(){
        if($this->authentication->login($_POST['email'],$_POST['password'])){
            header('location: index.php?route=login/success');
        }else{
            return['title'=>'Log in',
            'template'=>'login.html.php',
                'variables'=>[
                    'error'=>'Invalid username/password'
                ]];
        }
    }
    public function success(){
        return['title'=>'Login successful',
            'template'=>'success.html.php'];
    }
    public function logout(){
        unset($_SESSION);
        session_destroy();
        return['title'=>'You have successfully logged out',
            'template'=>'logout.html.php'];
    }
}