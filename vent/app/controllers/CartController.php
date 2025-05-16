<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;
// Ajout Stripe
require_once __DIR__ . '/../../vendor/autoload.php';

class CartController {
    public function add() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
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
                
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
        
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
        header('Location: /vent/index.php?url=panier/voir');
        exit;
    }

    public function payer() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /vent/index.php?url=user/login');
            exit;
        }
        $userId = $_SESSION['user_id'];
        $cartModel = new Cart();
        $cartItems = $cartModel->getCartContents($userId);
        if (empty($cartItems)) {
            header('Location: /vent/index.php?url=cart/voir');
            exit;
        }
        // Configuration de la clé secrète Stripe
        \Stripe\Stripe::setApiKey('sk_test_51ROKttRpnHMCqzKBtxwA0U9UJPPeUi9mQ9mjPAskQ8BfxQlIXqIcFBySph6QQ222VlsOg3Ma4dHyE3mqSllVkiwu00nqmgfb3k');
        $line_items = [];
        foreach ($cartItems as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['product_name'],
                    ],
                    'unit_amount' => intval($item['price'] * 100), // en centimes
                ],
                'quantity' => $item['quantity'],
            ];
        }
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/vent/index.php?url=panier/success',
            'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/vent/index.php?url=cart/voir',
        ]);
        header('Location: ' . $checkout_session->url);
        exit;
    }

    public function success() {
        include_once __DIR__ . '/../views/cart/success.php';
    }
}
?> 