<?php

namespace Ninja;

class EntryPoint
{
private $route;
private $routes;
private $method;

public function __construct(string $route, \Ninja\Routes $routes, string $method) {
$this -> route = $route;
$this -> routes = $routes;
$this->method = $method;
$this -> checkUrl();
}

private function checkUrl() {
    if(strtolower($this->route) !== $this->route) {
        http_response_code(301);
        header('location: index.php/'.strtolower($this->route));
    }
}

private function loadTemplate($templateFileName, $variables = []) {
    extract($variables);
    ob_start();
    include __DIR__ . '/../../templates/' .$templateFileName;
    return ob_get_clean();
}

public function run() {
    $routes = $this -> routes -> getRoutes($this->route);
    $controller = $routes[$this->route][$this->method]['controller'];
    $action = $routes[$this->route][$this->method]['action'];

    //var_dump($this->route);
    $page = $controller->$action();

    $title = $page['title'];

    if(isset($page['variables'])) {
        $output = $this->loadTemplate($page['template'], $page['variables']);
    }else{
        $output = $this->loadTemplate($page['template']);
    }
    include __DIR__ . '/../../templates/layout.html.php';
}
}