<?php



// Set src directory as the include path
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

require_once __DIR__ . '/../src/routes/web.php';
require_once __DIR__ . '/../src/Config/Database.php';

use Config\Database;
$db = new Database();
$db->createDefaultUserTableIfNotExists();

$requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// static files
$file = __DIR__ . $requestUrl;

if(file_exists($file) && is_file($file)) {
    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
    $contentTypes = [
        'html' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
    ];

    if (isset($contentTypes[$fileExtension])) {
        header('Content-Type: ' . $contentTypes[$fileExtension]);
    } else {
        header('Content-Type: application/octet-stream');
    }

    // Leer y enviar el archivo
    readfile($file);
    exit;
}


$requestMethod = $_SERVER['REQUEST_METHOD'];
$routeFound = false;

if(array_key_exists($requestMethod, $routes)) {
    foreach($routes[$requestMethod] as $route => $controller) {
        if (preg_match('@^' . str_replace(['${', '}'], ['(?P<', '>[^/]+)'], $route) . '$@', $requestUrl, $matches)) {
            [$controllerName, $controllerMethod] = $controller;
            $controllerName = new $controllerName();
            $controllerName->$controllerMethod($matches);
            $routeFound = true;
            break;
        }
    }
} else {
    http_response_code(405);
    echo '405 Method Not Allowed';
}

if (!$routeFound) {
    http_response_code(404);
    echo '404 Not Found';
}