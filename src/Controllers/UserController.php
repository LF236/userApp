<?php
namespace Controllers;
use Services\UserService;
use DTOs\User\Create as UserCreateDTO;

class UserController {
    protected $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function index() {
        $html = __DIR__ . '/../Views/index.html';
        if(file_exists($html)) {
            header('Content-Type: text/html');
            echo file_get_contents($html);
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }

    public function get() {
        $users = $this->userService->getAll();
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function create() {
        try {
            [$err, $data] = UserCreateDTO::create($_POST);
            header('Content-Type: application/json');

            if($err) {
                http_response_code(404);
                echo json_encode([
                    'errors' => $err,
                    'message' => 'Invalid data'
                ]);
                return;
            }
        
            $isCreatedUser = $this->userService->createUser($data);
            if($isCreatedUser) {
                echo json_encode([
                    'message' => 'User created'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'message' => 'Error creating user'
                ]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Unexpected error'
            ]);
        }
    }

    public function delete($params) {
        try {
            $id = $params['id'];
            $isDeletedUser = $this->userService->deleteUser($id);
            header('Content-Type: application/json');

            if($isDeletedUser) {
                echo json_encode([
                    'message' => 'User deleted'
                ]);
            } else {
                http_response_code(401);
                echo json_encode([
                    'message' => 'User not found'
                ]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Unexpected error'
            ]);
        }
    }

}