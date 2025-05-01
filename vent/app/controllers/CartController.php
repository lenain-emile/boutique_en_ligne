<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController {
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $sizeId = $_POST['size_id'] ?? null;
            
            // Pour l'instant, on utilise un ID utilisateur fixe (à remplacer par l'ID de l'utilisateur connecté)
            $userId = 1;
            
            if ($productId && $sizeId) {
                $cartModel = new Cart();
                $cartModel->addToCart($productId, $sizeId, $userId);
                
                // Rediriger vers la page du panier ou la page précédente
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
        
        // En cas d'erreur, rediriger vers la page précédente
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function view() {
        // Pour l'instant, on utilise un ID utilisateur fixe (à remplacer par l'ID de l'utilisateur connecté)
        $userId = 1;
        
        $cartModel = new Cart();
        $cartItems = $cartModel->getCartContents($userId);
        
        // Calculer le total du panier
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        include_once __DIR__ . '/../views/cart/panier.php';
    }

    public function clear() {
        // Pour l'instant, on utilise un ID utilisateur fixe (à remplacer par l'ID de l'utilisateur connecté)
        $userId = 1;
        
        $cartModel = new Cart();
        $cartModel->clearCart($userId);
        
        // Rediriger vers la page du panier
        header('Location: /vent/cart/view');
        exit;
    }
}
?> 