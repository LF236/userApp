<?php
namespace DTOs\User;

class Create {
    public $name;
    public $email;
    public $firstName;
    public $lastName;

    public function __construct($name, $email, $firstName, $lastName) {
        $this->name = $name;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    private static function validate($data) {
        if(!isset($data['username'])) {
            return ['Username is required'];
        }

        if(!isset($data['email'])) {
            return ['Email is required'];
        }

        if(!isset($data['firstName'])) {
            return ['FirstName is required'];
        }

        if(!isset($data['lastName'])) {
            return ['LastName is required'];
        }
    }

    public static function create($data) {
        $errors = self::validate($data);

        if($errors) {
            return [$errors, null];
        }

        $newUser = new self($data['username'], $data['email'], $data['firstName'], $data['lastName']);
        
        return [null, $newUser];
    }
}