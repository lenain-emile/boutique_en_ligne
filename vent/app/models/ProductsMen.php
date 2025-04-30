<?php
namespace App\Models;

use App\Config\Database;

class ProductsMen extends Database {
    // Récupère tous les produits pour les hommes (genre_id = 1)
    public function getAllProducts() {
        $db = $this->connect();
        $stmt = $db->query("SELECT * FROM products WHERE gender_id = 1"); // Filtre par genre homme
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Ajouter le chemin correct pour les images
        foreach ($products as &$product) {
            if (!empty($product['image'])) {
                $product['image'] = '/vent/public/image/' . $product['image'];
            }
        }
        
        return $products;
    }

    // Récupère un produit spécifique par son ID pour les hommes
    public function getProductById($id) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ? AND gender_id = 1"); // Filtre pour genre homme
        $stmt->execute([$id]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Ajouter le chemin correct pour l'image
        if ($product && !empty($product['image'])) {
            $product['image'] = '/vent/public/image/' . $product['image'];
        }
        
        return $product;
    }

    // Récupère les tailles disponibles pour un produit donné
    public function getSizesByProductId($productId) {
        $db = $this->connect();
        $stmt = $db->prepare("
            SELECT sizes.id, sizes.label 
            FROM sizes
            INNER JOIN product_size ON product_size.size_id = sizes.id
            WHERE product_size.product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
