<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController {
    public function add() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /vent/index.php?url=user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $sizeId = $_POST['size_id'] ?? null;
            $userId = $_SESSION['user_id'];
            
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /vent/index.php?url=user/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        
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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /vent/index.php?url=user/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        
        $cartModel = new Cart();
        $cartModel->clearCart($userId);
        
        // Rediriger vers la page du panier
        header('Location: /vent/cart/view');
        exit;
    }
}
?> 