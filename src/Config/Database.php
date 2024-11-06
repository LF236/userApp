<?php
namespace Config;
use Config\LoadEnvConfig;

class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $pdo;

    public function __construct() {
        $env = new LoadEnvConfig();
        $env->loadEnv();

        $this->host = getenv('DB_HOST');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');

        try {
            $dsn = "mysql:host=$this->host;dbname=$this->database";
            $this->pdo = new \PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Error de conexion: ' . $e->getMessage();
        }
    }

    // Return data
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Not return data
    public function exec($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function createDefaultUserTableIfNotExists() {
        $this->pdo->query('USE ' . $this->database);
        $sql = 'SHOW TABLES LIKE "users"';
        $stmt = $this->pdo->query($sql);

        if($stmt->rowCount() === 0) {
            $sql = 'CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                userName VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                firstName VARCHAR(255) NOT NULL,
                lastName VARCHAR(255) NOT NULL
            )';
            $this->pdo->exec($sql);
        }
    }
}