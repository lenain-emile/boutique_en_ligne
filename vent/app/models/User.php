<?php
namespace App\models;

use App\config\Database;
use PDO;

class User
{
    private $username;
    private $email;
    private $password;
    private $role = 'user'; 

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function save()
    {
        $database = new Database();
        $db = $database->connect();
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->username, $this->email, $this->password, $this->role]);
    }

    public static function findByUsername($username)
    {
        $database = new Database();
        $db = $database->connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 