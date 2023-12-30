<?php
$routes = [
    '/' => 'TaskController@index',
    '/api/v1/task/?(\d+)?' => 'ApiController@index',
];

$url = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$routeHandler = null;

foreach ($routes as $routePattern => $handler) {
    if (preg_match("#^$routePattern$#", $url, $matches)) {
        $routeHandler = $handler;
        break;
    }
}

if ($routeHandler) {
    list($controller, $method) = explode('@', $routeHandler);

    require_once "./controllers/$controller.php";

    $instance = new $controller();

    if (method_exists($instance, 'setId')) {
        $id = isset($matches[1]) ? $matches[1] : null;
        $instance->setId($id);
    }

    $instance->$method();
} else {
    echo $url . '<br>';
    echo "404 Not Found";
}
