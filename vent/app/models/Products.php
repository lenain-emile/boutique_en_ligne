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
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
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
            SELECT sizes.id, sizes.label 
            FROM sizes
            INNER JOIN product_size ON product_size.size_id = sizes.id
            WHERE product_size.product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($categoryId) {
        $db = $this->connect();
        $stmt = $db->prepare("SELECT * FROM products WHERE gender_id = 2 AND category_id = ?");
        $stmt->execute([$categoryId]);
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Ajouter le chemin correct pour les images
        foreach ($products as &$product) {
            if (!empty($product['image'])) {
                $product['image_url'] = '/vent/public/image/' . $product['image'];
            }
        }
        
        return $products;
    }

    public function getAllCategories() {
        $db = $this->connect();
        $stmt = $db->query("SELECT * FROM categories");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $description, $price, $image, $categoryId, $genderId) {
        $db = $this->connect();
        $stmt = $db->prepare("
            INSERT INTO products (name, description, price, image, category_id, gender_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $description, $price, $image, $categoryId, $genderId]);
        return $db->lastInsertId();
    }

    public function addProductSizes($productId, $sizeIds) {
        $db = $this->connect();
        $stmt = $db->prepare("INSERT INTO product_size (product_id, size_id) VALUES (?, ?)");
        
        foreach ($sizeIds as $sizeId) {
            $stmt->execute([$productId, $sizeId]);
        }
        
        return true;
    }

    public function getProductSizes($productId) {
        $db = $this->connect();
        $stmt = $db->prepare("
            SELECT size_id 
            FROM product_size 
            WHERE product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function updateProductSizes($productId, $newSizeIds) {
        $db = $this->connect();
        
        // Supprimer toutes les tailles existantes
        $stmt = $db->prepare("DELETE FROM product_size WHERE product_id = ?");
        $stmt->execute([$productId]);
        
        // Ajouter les nouvelles tailles
        if (!empty($newSizeIds)) {
            $stmt = $db->prepare("INSERT INTO product_size (product_id, size_id) VALUES (?, ?)");
            foreach ($newSizeIds as $sizeId) {
                $stmt->execute([$productId, $sizeId]);
            }
        }
        
        return true;
    }

    public function updateProduct($id, $name, $description, $price, $image, $categoryId, $genderId) {
        $db = $this->connect();
        $stmt = $db->prepare("
            UPDATE products 
            SET name = ?, description = ?, price = ?, image = ?, category_id = ?, gender_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $description, $price, $image, $categoryId, $genderId, $id]);
    }

    public function deleteProduct($id) {
        $db = $this->connect();
        
        // Supprimer d'abord les relations avec les tailles
        $stmt = $db->prepare("DELETE FROM product_size WHERE product_id = ?");
        $stmt->execute([$id]);
        
        // Ensuite supprimer le produit
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
