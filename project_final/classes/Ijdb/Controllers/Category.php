<?php


namespace Ijdb\Controllers;


class Category
{
    private $categoriesTable;
    private $jokesTable;

    public function __construct(\Ninja\DatabaseTable $categoriesTable){
        $this->categoriesTable=$categoriesTable;
    }

    public function edit(){
        if(isset($_GET['id'])){
            $category = $this->categoriesTable->findById($_GET['id']);
        }
        $title = 'Edit category';
        return ['title'=>$title,
            'template'=>'editcategory.html.php',
            'variables'=>[
                'category'=>$category ?? null
            ]
        ];
    }
    public function saveEdit(){
        $category = $_POST['category'];
        $this->categoriesTable->save($category);
        header('location: index.php?route=category/list');
    }
    public function list(){
        $categories = $this->categoriesTable->findAll();
        $title = 'Joke categories';
        return ['title'=>$title,
            'template'=>'categories.html.php',
            'variables'=>[
                'categories'=>$categories
            ]
        ];
    }
    public function delete(){
        $this->categoriesTable->delete($_POST['id']);
        header('location: index.php?route=category/list');
    }
}