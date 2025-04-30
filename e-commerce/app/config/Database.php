<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $dbname = 'e_shop';
    private $username = 'root';
    private $password = '';

    protected function connect(): PDO {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    public static function getConnection(): PDO {
        $instance = new self();
        return $instance->connect();
    }
}

?>