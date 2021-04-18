<?php

namespace Ijdb\Controllers;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Joke
{
    private $jokesTable;
    private $authorsTable;
    private $categoriesTable;
    private $authentication;

    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication, DatabaseTable $categoriesTable){
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->authentication = $authentication;
        $this->categoriesTable = $categoriesTable;
    }
    public function list() {
        $page = $_GET['page'] ?? 1;
        $offset = ($page-1)*5;
        if(isset($_GET['category'])){
            $category = $this->categoriesTable->findById($_GET['category']);
            $jokes = $category->getJokes($offset, 5);
            $totalJokes = $category->getNumJokes();
        }else{
            $jokes = $this->jokesTable->findAll('`jokedate` DESC', 5, $offset);
            $totalJokes = $this->jokesTable->total();
        }
        $title = 'Joke list';

        $author = $this->authentication->getUser();
        return ['template' => 'jokes.html.php',
            'title' => $title,
            'variables' => [
                'totalJokes' => $totalJokes,
                'jokes' => $jokes,
                'user' => $author,
                'categories' => $this->categoriesTable->findAll(),
                'currentPage'=>$page,
                'categoryId'=>$_GET['category'] ?? null
            ]
        ];
    }
    public function home() {
        $title = 'Internet Joke Database';
        return ['template' => 'home.html.php', 'title' => $title];
    }
    public function delete() {
        $author = $this->authentication->getUser();
        $joke = $this->jokesTable->findById($_POST['id']);
            if($joke->authorid!=$author->id && !$author->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)){
                return;
            }   
        $this->jokesTable->delete($_POST['id']);
        header('location: index.php?route=joke/list');
    }
    public function saveEdit() {
        $author = $this->authentication->getUser();
//        if(isset($_GET['id'])) {
//            $joke = $this->jokesTable->findById($_GET['id']);
//            if($joke->authorid!=$author->id){
//                return;
//            }
//        }

        $joke = $_POST['joke'];
        $joke['jokedate'] = new \DateTime();

        $jokeEntity = $author->addJoke($joke);
        $jokeEntity->clearCategories();

         if(isset($_POST['category'])){
            foreach($_POST['category'] as $categoryId){
                $jokeEntity->addCategory($categoryId);
           }
        }

        header('location: index.php?route=joke/list');
    }
    public function edit() {
        $author = $this->authentication->getUser();
        $categories = $this->categoriesTable->findAll();
        if(isset($_GET['id'])) {
            $joke = $this->jokesTable->findById($_GET['id']);
        }
        $title = 'Edit joke';
        $userId = $author->id;
        return ['template'=>'editjoke.html.php',
            'title'=>$title,
            'variables'=>[
                'joke'=>$joke ?? null,
                //'userId '=>$author->id ?? null,
                'user'=>$author,
                'categories'=>$categories
            ]
        ];
    }
}