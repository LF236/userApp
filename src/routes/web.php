<?php
use Controllers\UserController;

$routes = [
    'GET' => [
        '/users' => [UserController::class, 'get'],
    ],
    'POST' => [
        '/users' => [UserController::class, 'create'],
    ],
    'DELETE' => [
        '/users/${id}' => [UserController::class, 'delete'],
    ],
];