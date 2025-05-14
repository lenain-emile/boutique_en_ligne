<?php
namespace App\Models;

use App\Config\Database;

class Sizes extends Database {
    public function getAllSizes() {
        $db = $this->connect();
        $stmt = $db->query("SELECT * FROM sizes ORDER BY label");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSizeById($id) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT * FROM sizes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addSize($label) {
        $db = $this->connect();
        $stmt = $db->prepare("INSERT INTO sizes (label) VALUES (?)");
        return $stmt->execute([$label]);
    }

    public function updateSize($id, $label) {
        $db = $this->connect();
        $stmt = $db->prepare("UPDATE sizes SET label = ? WHERE id = ?");
        return $stmt->execute([$label, $id]);
    }

    public function deleteSize($id) {
        $db = $this->connect();
        
        // Supprimer d'abord les relations avec les produits
        $stmt = $db->prepare("DELETE FROM product_size WHERE size_id = ?");
        $stmt->execute([$id]);
        
        // Ensuite supprimer la taille
        $stmt = $db->prepare("DELETE FROM sizes WHERE id = ?");
        return $stmt->execute([$id]);
    }
} 