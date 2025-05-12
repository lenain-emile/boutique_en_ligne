<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Address
{
    private $first_name;
    private $last_name;
    private $street;
    private $postal_code;
    private $phone;
    private $user_id;

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function save()
    {
        $database = new Database();
        $db = $database->connect();
        $stmt = $db->prepare("INSERT INTO addresses (first_name, last_name, street, postal_code, phone, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->first_name,
            $this->last_name,
            $this->street,
            $this->postal_code,
            $this->phone,
            $this->user_id
        ]);
    }

    public static function findByUserId($user_id)
    {
        $database = new Database();
        $db = $database->connect();
        $stmt = $db->prepare("SELECT * FROM addresses WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}