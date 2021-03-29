<?php

namespace Ijdb;

class IjdbRoutes implements \Ninja\Routes
{
    public function getRoutes($route) {
        include __DIR__ . '/../../includes/DatabaseConnection.php';

        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');

        $jokeController = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
        $authorController = new \Ijdb\Controllers\Register($authorsTable);

        $routes = [
            'joke/edit'=>[
                'POST'=>[
                    'controller'=>$jokeController,
                    'action'=>'saveEdit'
                ],
                'GET'=>[
                    'controller'=>$jokeController,
                    'action'=>'edit'
                ]
            ],
            'joke/list'=>[
                'GET'=>[
                    'controller'=>$jokeController,
                    'action'=>'list'
                ]
            ],
            'joke/home'=>[
                'GET'=>[
                    'controller'=>$jokeController,
                    'action'=>'home'
                ]
            ],
            'joke/delete'=>[
                'POST'=>[
                    'controller'=>$jokeController,
                    'action'=>'delete'
                ]
            ],
            'author/register'=>[
                'GET'=>[
                    'controller'=>$authorController,
                    'action'=>'registrationForm'
                ],
                'POST'=>[
                    'controller'=>$authorController,
                    'action'=>'registerUser'
                ]
            ],
            'author/success'=>[
                'GET'=>[
                    'controller'=>$authorController,
                    'action'=>'success'
                ]
            ]
        ];


        return $routes;
    }
}
