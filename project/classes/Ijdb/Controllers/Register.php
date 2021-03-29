<?php


namespace Ijdb\Controllers;

use Ninja\DatabaseTable;

class Register
{
    private $authorsTable;

    public function __construct(DatabaseTable $authorsTable) {
        $this->authorsTable = $authorsTable;
    }

    public function registrationForm() {
        $template = 'register.html.php';
        return ['template'=>$template,
            'title'=>'Register an account'];
    }
    public function success() {
        $template = 'registersuccess.html.php';
        return ['template'=>$template,
            'title'=>'Registration successful'];
    }
    public function registerUser() {
        $author = $_POST['author'];

        $valid = true;
        $errors =[];

        if(empty($author['name'])){
            $valid = false;
            $errors[]= 'Name can not be blank';
        }
        if(empty($author['password'])){
            $valid = false;
            $errors[]= 'Password can not be blank';
        }
        if(empty($author['email'])){
            $valid = false;
            $errors[]= 'Email can not be blank';
        }else if(filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false){
            $valid = false;
            $errors[]= 'Invalid email adress';
        }else {
            $author['email']=strtolower($author['email']);
            if(count($this->authorsTable->find('email',$author['email']))>0) {
                $valid = false;
                $errors[]='An user with this email adress has been already registered';
            }
        }
        if($valid == true) {
            $author['password']=password_hash($author['password'], PASSWORD_DEFAULT);
            $this->authorsTable->save($author);
            header('location: index.php?route=author/success');
        }else{
            $template = 'register.html.php';
            return ['template'=>$template,
                'title'=>'Register an account',
                'variables'=>[
                    'errors'=>$errors,
                    'author'=>$author
                ]];
        }

    }
}