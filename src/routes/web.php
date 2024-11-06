<?php
use Controllers\UserController;

$routes = [
    'GET' => [
        '/users' => [UserController::class, 'get'],
        '/' => [UserController::class, 'index'],
    ],
    'POST' => [
        '/users' => [UserController::class, 'create'],
    ],
    'DELETE' => [
        '/users/${id}' => [UserController::class, 'delete'],
    ],
];