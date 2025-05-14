<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Order extends Database {
    public function getOrdersByUserId($userId) {
        $db = $this->connect();
        
        // Récupérer les commandes de l'utilisateur avec les détails
        $stmt = $db->prepare("
            SELECT 
                o.id,
                o.order_date,
                o.total,
                o.status,
                a.first_name,
                a.last_name,
                a.street,
                a.postal_code,
                a.phone
            FROM orders o
            LEFT JOIN addresses a ON o.address_id = a.id
            WHERE o.user_id = ?
            ORDER BY o.order_date DESC
        ");
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Pour chaque commande, récupérer les détails des produits
        foreach ($orders as &$order) {
            $stmt = $db->prepare("
                SELECT 
                    od.quantity,
                    od.unit_price,
                    p.name as product_name,
                    p.image,
                    s.label as size_label
                FROM order_details od
                JOIN products p ON od.product_id = p.id
                JOIN sizes s ON od.size_id = s.id
                WHERE od.order_id = ?
            ");
            $stmt->execute([$order['id']]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Ajouter le chemin correct pour les images
            foreach ($order['items'] as &$item) {
                if (!empty($item['image'])) {
                    $item['image_url'] = '/vent/public/image/' . $item['image'];
                }
            }
        }
        
        return $orders;
    }
}
?> 