<?php
try {
    include __DIR__ . '/../includes/autoload.php';

    $route = $_GET['route'] ?? 'joke/home';
    //$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

    $entryPoint = new \Ninja\EntryPoint($route, new \Ijdb\IjdbRoutes(), $_SERVER['REQUEST_METHOD']);
    $entryPoint->run();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in '
        . $e->getFile() . ':' . $e->getLine();
    include __DIR__ . '/../templates/layout.html.php';
}
//include __DIR__ . '/../templates/layout.html.php';

