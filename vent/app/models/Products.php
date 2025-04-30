<?php
namespace App\Models;

use App\Config\Database;

class Products extends Database {
    public function getAllProducts() {
        $db = $this->connect();
        $stmt = $db->query("SELECT * FROM products WHERE gender_id = 2");
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Ajouter le chemin correct pour les images
        foreach ($products as &$product) {
            if (!empty($product['image'])) {
                $product['image_url'] = '/vent/public/image/' . $product['image'];
            }
        }
        
        return $products;
    }

    public function getProductById($id) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ? AND gender_id = 2");
        $stmt->execute([$id]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // Ajouter le chemin correct pour l'image
        if ($product && !empty($product['image'])) {
            $product['image_url'] = '/vent/public/image/' . $product['image'];
        }
        
        return $product;
    }

    public function getSizesByProductId($productId) {
        $db = $this->connect();
        $stmt = $db->prepare("
            SELECT sizes.label 
            FROM sizes
            INNER JOIN product_size ON product_size.size_id = sizes.id
            WHERE product_size.product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}
?>
