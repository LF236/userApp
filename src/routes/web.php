<?php

use Controllers\AuthController;
use Controllers\UserController;

$routes = [
    'GET' => [
        '/users' => [UserController::class, 'get'],
        '/users/${id}' => [UserController::class, 'getUserById'],
        '/' => [UserController::class, 'index'],
        '/auth' => [AuthController::class, 'index'], 

    ],

    'POST' => [
        '/users' => [UserController::class, 'create'],
        '/users/update/${id}' => [UserController::class, 'update'],
        '/auth/login' => [AuthController::class, 'login'],
        '/auth/logout' => [AuthController::class, 'logout'],
    ],

    'DELETE' => [
        '/users/${id}' => [UserController::class, 'delete'],
    ],
];