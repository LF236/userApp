<?php
namespace Repositories;
use DTOs\User\Create as UserCreateDTO;
use Config\Database;
class UserRepository {
    public function __construct() {
    }

    public function saveUser(UserCreateDTO $user) {
        $db = new Database();

        $sql = 'INSERT INTO users (userName, email, firstName, lastName) VALUES (:userName, :email, :firstName, :lastName)';
        $params = [
            'userName' => $user->name,
            'email' => $user->email,
            'firstName' => $user->firstName,
            'lastName' => $user->lastName
        ];

        if($db->exec($sql, $params)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id) {
        $db = new Database();
        $sql = 'SELECT * FROM users WHERE id = :id';
        $params = [
            'id' => $id
        ];
        return $db->query($sql, $params);
    }

    public function deleteUserById($id) {
        $db = new Database();
        $userFound = $this->getUserById($id);
        if(!$userFound) {
            return false;
        }
        $sql = 'DELETE FROM users WHERE id = :id';
        $params = [
            'id' => $id
        ];
        return $db->exec($sql, $params);
    }

    public function getAllUsers() {
        $db = new Database();
        $sql = 'SELECT * FROM users ORDER BY id DESC';
        return $db->query($sql);
    }

    public function updateUserById($id, $data) {
        $db = new Database();
        $userFound = $this->getUserById($id);
        if(!$userFound) {
            return false;
        }
        $sql = 'UPDATE users SET userName = :userName, email = :email, firstName = :firstName, lastName = :lastName WHERE id = :id';
        $params = [
            'id' => $id,
            'userName' => $data->name,
            'email' => $data->email,
            'firstName' => $data->firstName,
            'lastName' => $data->lastName
        ];
        return $db->exec($sql, $params);
    }
}