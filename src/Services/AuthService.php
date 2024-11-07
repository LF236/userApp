<?php
namespace Services;

class AuthService {
    public function login($user, $password) {
        if($user === 'admin' && $password === 'admin') {
            $token = base64_encode(random_bytes(32));
            setcookie('token', $token, time() + 3600, '/');
            $_SESSION['auth_token'] = $token;
            return true;
        }
        return false;
    }

    public function validateToken() {
        $token = $_COOKIE['token'] ?? null;
        $sessionToken = $_SESSION['auth_token'] ?? null;
        if(isset($token) && isset($sessionToken)) {
            return $token === $sessionToken;
        } else {
            return false;
        }
    }
}