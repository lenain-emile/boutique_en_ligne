<?php
namespace App\Models;

use App\Config\Database; // ALLOW MEE TPO USE THE DATABASE CLASS WITHOUT WRITING THE FULL PATH EPIC thing

class Products extends Database {
    public function getAllProducts() {
        // Connexion à la base de données
        $db = $this->connect();
        
        // Requête pour récupérer tous les produits
        $stmt = $db->query("SELECT * FROM WE I NEED REQUESTLOL");  

    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
