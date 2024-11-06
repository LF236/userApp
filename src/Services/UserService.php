<?php
namespace Services;
use Repositories\UserRepository;
use DTOs\User\Create as UserCreateDTO;

class UserService {
    private $userRepository;
    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function createUser(UserCreateDTO $user) {
        return $this->userRepository->saveUser($user);
    }

    public function deleteUser($id) {
        return $this->userRepository->deleteUserById($id);
    }

    public function getAll() {
        return $this->userRepository->getAllUsers();
    }
}