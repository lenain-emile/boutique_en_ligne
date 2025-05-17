<?php
namespace App\Models;

use App\Config\Database;

class Cart extends Database {
    public function addToCart($productId, $sizeId, $userId) {
        $db = $this->connect();
        
        // Vérifier si l'utilisateur a déjà un panier actif
        $stmt = $db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$cart) {
            // Créer un nouveau panier si l'utilisateur n'en a pas
            $stmt = $db->prepare("INSERT INTO carts (user_id) VALUES (?)");
            $stmt->execute([$userId]);
            $cartId = $db->lastInsertId();
        } else {
            $cartId = $cart['id'];
        }
        
        // Vérifier si le produit avec cette taille existe déjà dans le panier
        $stmt = $db->prepare("
            SELECT id, quantity 
            FROM cart_details 
            WHERE cart_id = ? AND product_id = ? AND size_id = ?
        ");
        $stmt->execute([$cartId, $productId, $sizeId]);
        $existingItem = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($existingItem) {
            // Mettre à jour la quantité si l'article existe déjà
            $stmt = $db->prepare("
                UPDATE cart_details 
                SET quantity = quantity + 1 
                WHERE id = ?
            ");
            $stmt->execute([$existingItem['id']]);
        } else {
            // Ajouter un nouvel article au panier
            $stmt = $db->prepare("
                INSERT INTO cart_details (cart_id, product_id, size_id, quantity) 
                VALUES (?, ?, ?, 1)
            ");
            $stmt->execute([$cartId, $productId, $sizeId]);
        }
        
        return true;
    }

    public function getCartContents($userId) {
        $db = $this->connect();
        
        // Récupérer le panier de l'utilisateur
        $stmt = $db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$cart) {
            return [];
        }
        
        // Récupérer les détails du panier avec les informations des produits et des tailles
        $stmt = $db->prepare("
            SELECT 
                cd.id as cart_detail_id,
                cd.quantity,
                p.id as product_id,
                p.name as product_name,
                p.price,
                p.image,
                s.id as size_id,
                s.label as size_label
            FROM cart_details cd
            JOIN products p ON cd.product_id = p.id
            JOIN sizes s ON cd.size_id = s.id
            WHERE cd.cart_id = ?
        ");
        $stmt->execute([$cart['id']]);
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Ajouter le chemin correct pour les images
        foreach ($items as &$item) {
            if (!empty($item['image'])) {
                $item['image_url'] = '/vent/public/image/' . $item['image'];
            }
        }
        
        return $items;
    }

    public function clearCart($userId) {
        $db = $this->connect();
        
        // Récupérer l'ID du panier de l'utilisateur
        $stmt = $db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($cart) {
            // Supprimer tous les articles du panier
            $stmt = $db->prepare("DELETE FROM cart_details WHERE cart_id = ?");
            $stmt->execute([$cart['id']]);
            
            // Supprimer le panier lui-même
            $stmt = $db->prepare("DELETE FROM carts WHERE id = ?");
            $stmt->execute([$cart['id']]);
        }
        
        return true;
    }

    public function mergeCart($userId, $temporaryCart) {
        if (empty($temporaryCart)) {
            return true;
        }

        $db = $this->connect();
        
        // Récupérer ou créer le panier de l'utilisateur
        $stmt = $db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$cart) {
            $stmt = $db->prepare("INSERT INTO carts (user_id) VALUES (?)");
            $stmt->execute([$userId]);
            $cartId = $db->lastInsertId();
        } else {
            $cartId = $cart['id'];
        }

        // Fusionner les articles du panier temporaire avec le panier de l'utilisateur
        foreach ($temporaryCart as $item) {
            $productId = $item['product_id'];
            $sizeId = $item['size_id'];
            $quantity = $item['quantity'];

            // Vérifier si l'article existe déjà dans le panier de l'utilisateur
            $stmt = $db->prepare("
                SELECT id, quantity 
                FROM cart_details 
                WHERE cart_id = ? AND product_id = ? AND size_id = ?
            ");
            $stmt->execute([$cartId, $productId, $sizeId]);
            $existingItem = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($existingItem) {
                // Mettre à jour la quantité
                $stmt = $db->prepare("
                    UPDATE cart_details 
                    SET quantity = quantity + ? 
                    WHERE id = ?
                ");
                $stmt->execute([$quantity, $existingItem['id']]);
            } else {
                // Ajouter un nouvel article
                $stmt = $db->prepare("
                    INSERT INTO cart_details (cart_id, product_id, size_id, quantity) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([$cartId, $productId, $sizeId, $quantity]);
            }
        }

        return true;
    }
}
?> 