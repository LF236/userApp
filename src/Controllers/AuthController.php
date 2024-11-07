<?php
namespace Controllers;

use Services\AuthService;

class AuthController {
    protected $authService;
    public function __construct() {
        $this->authService = new AuthService();
        session_start();
    }

    public function index() {
        $html = __DIR__ . '/../Views/login.html';
        $isOkToken = $this->authService->validateToken();
        if($isOkToken) {
            header("Location: /"); 
            exit();
        } else {
            if(file_exists($html)) {
                header('Content-Type: text/html');
                echo file_get_contents($html);
            } else {
                http_response_code(404);
                echo '404 Not Found';
            }
        }
    }

    public function login() {
        $user = $_POST['user'];
        $password = $_POST['password'];

        $isOk = $this->authService->login($user, $password);

        if($isOk) {
            
            http_response_code(200);
            echo json_encode([
                'message' => 'Login success'
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'message' => 'Login failed'
            ]);
        }
    }

    public function logout() {
        setcookie('token', '', time() - 3600, '/');
        unset($_SESSION['auth_token']);
        http_response_code(200);
        echo json_encode([
            'message' => 'Logout success'
        ]);
    }
}