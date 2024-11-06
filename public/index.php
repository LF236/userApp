<?php

require_once __DIR__ . '/../routes/web.php';


$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$foundRoute = false;

foreach ($routes as $route => $handler) {
    if($route === $request) {
        [$controller, $method] = $handler;
        $controller = new $controller();

        call_user_func([$controller, $method]);
        $foundRoute = true;
        break;
    }
}

if(!$foundRoute) {
    http_response_code(404);
    echo '404 Not Found';
}