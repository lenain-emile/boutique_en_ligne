<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Order;

class UserController {
    public function login() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = User::findByUsername($username);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header('Location: /vent/index.php?url=dashboard');
                exit;
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect";
                require_once __DIR__ . '/../views/users/utilisateur.php';
            }
        } else {
            require_once __DIR__ . '/../views/users/utilisateur.php';
        }
    }

    public function register() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            
            if ($user->save()) {
                header('Location: /vent/index.php?url=user/login');
                exit;
            } else {
                $error = "Erreur lors de l'inscription";
                require_once __DIR__ . '/../views/users/register.php';
            }
        } else {
            require_once __DIR__ . '/../views/users/register.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /vent/index.php?url=user/login');
        exit;
    }

    public function orders() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /vent/index.php?url=user/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $orderModel = new Order();
        
        // Si l'utilisateur est admin, afficher toutes les commandes
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            $orders = $orderModel->getAllOrders();
        } else {
            // Sinon, afficher uniquement les commandes de l'utilisateur
            $orders = $orderModel->getOrdersByUserId($userId);
        }
        
        // Afficher la vue des commandes
        require_once __DIR__ . '/../views/orders/commande.php';
    }
} 