<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Order extends Database {
    public function createOrder($userId, $addressId, $cartItems) {
        $db = $this->connect();
        
        try {
            $db->beginTransaction();

            // Calculer le montant total
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Créer la commande
            $stmt = $db->prepare("
                INSERT INTO orders (user_id, address_id, total, status, order_date)
                VALUES (?, ?, ?, 'pending', NOW())
            ");

            $stmt->execute([$userId, $addressId, $totalAmount]);
            $orderId = $db->lastInsertId();

            // Ajouter les articles de la commande
            $stmt = $db->prepare("
                INSERT INTO order_details (order_id, product_id, size_id, quantity, unit_price)
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($cartItems as $item) {
                $stmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['size_id'],
                    $item['quantity'],
                    $item['price']
                ]);
            }

            $db->commit();
            return $orderId;

        } catch (\Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    public function getOrdersByUserId($userId) {
        $db = $this->connect();
        
        // Récupérer les commandes avec les adresses
        $stmt = $db->prepare("
            SELECT o.*, 
                   a.first_name, a.last_name, a.street, a.postal_code, a.phone
            FROM orders o
            JOIN addresses a ON o.address_id = a.id
            WHERE o.user_id = ?
            ORDER BY o.order_date DESC
        ");
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Pour chaque commande, récupérer les articles
        foreach ($orders as &$order) {
            $stmt = $db->prepare("
                SELECT od.*, p.name as product_name, p.image, s.label as size_label
                FROM order_details od
                JOIN products p ON od.product_id = p.id
                JOIN sizes s ON od.size_id = s.id
                WHERE od.order_id = ?
            ");
            $stmt->execute([$order['id']]);
            $order['items'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Ajouter le chemin correct pour les images
            foreach ($order['items'] as &$item) {
                if (!empty($item['image'])) {
                    $item['image_url'] = '/vent/public/image/' . $item['image'];
                }
            }
        }

        return $orders;
    }

    public function getAllOrders() {
        $db = $this->connect();
        
        // Récupérer toutes les commandes avec les informations utilisateur et adresse
        $stmt = $db->prepare("
            SELECT o.*, 
                   u.username,
                   a.first_name, a.last_name, a.street, a.postal_code, a.phone
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN addresses a ON o.address_id = a.id
            ORDER BY o.order_date DESC
        ");
        $stmt->execute();
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Pour chaque commande, récupérer les articles
        foreach ($orders as &$order) {
            $stmt = $db->prepare("
                SELECT od.*, p.name as product_name, p.image, s.label as size_label
                FROM order_details od
                JOIN products p ON od.product_id = p.id
                JOIN sizes s ON od.size_id = s.id
                WHERE od.order_id = ?
            ");
            $stmt->execute([$order['id']]);
            $order['items'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Ajouter le chemin correct pour les images
            foreach ($order['items'] as &$item) {
                if (!empty($item['image'])) {
                    $item['image_url'] = '/vent/public/image/' . $item['image'];
                }
            }
        }

        return $orders;
    }

    public function updateOrderStatus($orderId, $status) {
        $db = $this->connect();
        
        $stmt = $db->prepare("
            UPDATE orders 
            SET status = ? 
            WHERE id = ?
        ");
        
        return $stmt->execute([$status, $orderId]);
    }
}
?> 