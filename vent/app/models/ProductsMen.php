<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class ProductsMen extends Database {
    // Récupère tous les produits pour les hommes (genre_id = 1)
    public function getAllProducts() {
        try {
            $db = $this->connect();
            $stmt = $db->query("SELECT * FROM products WHERE gender_id = 1");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Ajouter le chemin correct pour les images
            foreach ($products as &$product) {
                if (!empty($product['image'])) {
                    $product['image'] = '/vent/public/image/' . $product['image'];
                }
            }
            
            return $products;
        } catch (PDOException $e) {
            error_log("Erreur dans getAllProducts: " . $e->getMessage());
            return [];
        }
    }

    // Récupère un produit spécifique par son ID pour les hommes
    public function getProductById($id) {
        try {
            $db = $this->connect();
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ? AND gender_id = 1");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product && !empty($product['image'])) {
                $product['image'] = '/vent/public/image/' . $product['image'];
            }
            
            return $product;
        } catch (PDOException $e) {
            error_log("Erreur dans getProductById: " . $e->getMessage());
            return null;
        }
    }

    // Récupère les tailles disponibles pour un produit donné
    public function getSizesByProductId($productId) {
        try {
            $db = $this->connect();
            $stmt = $db->prepare("
                SELECT sizes.id, sizes.label 
                FROM sizes
                INNER JOIN product_size ON product_size.size_id = sizes.id
                WHERE product_size.product_id = ?
            ");
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getSizesByProductId: " . $e->getMessage());
            return [];
        }
    }

    public function getProductsByCategory($categoryId) {
        try {
            $db = $this->connect();
            $stmt = $db->prepare("SELECT * FROM products WHERE gender_id = 1 AND category_id = ?");
            $stmt->execute([$categoryId]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($products as &$product) {
                if (!empty($product['image'])) {
                    $product['image'] = '/vent/public/image/' . $product['image'];
                }
            }
            
            return $products;
        } catch (PDOException $e) {
            error_log("Erreur dans getProductsByCategory: " . $e->getMessage());
            return [];
        }
    }

    public function getAllCategories() {
        try {
            $db = $this->connect();
            $stmt = $db->query("SELECT * FROM categories");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur dans getAllCategories: " . $e->getMessage());
            return [];
        }
    }
}
?>
