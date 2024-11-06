<?php

use Controllers\UserController;

$routes = [
    '/' => [UserController::class, 'index']
];