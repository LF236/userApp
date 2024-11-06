<?php

namespace Entities;

class UserEntitie {
    private int $id;
    private string $userName;
    private string $email;
    private string $firstName;
    private string $lastName;

    public function __construct(int $id, string $userName, string $email, string $firstName, string $lastName) {
        $this->id = $id;
        $this->userName = $userName;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getSelf() {
        return $this;
    }
}