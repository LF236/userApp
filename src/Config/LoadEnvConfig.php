<?php

namespace Config;

class LoadEnvConfig {
    public $envFile = __DIR__ . '/../../.env';

    public function __construct() {
        $this->loadEnv();
    }

    public function loadEnv() {

        if (!file_exists($this->envFile)) {
            throw new \Exception("The .env file does not exist");
        }

        $lines = file($this->envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            list($key, $value) = explode('=', $line, 2);
            putenv("$key=$value");
        }
    }
}
