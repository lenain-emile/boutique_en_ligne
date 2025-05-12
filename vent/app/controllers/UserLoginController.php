<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Cart;

class UserLoginController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Sauvegarder le panier temporaire s'il existe
                $temporaryCart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
                
                // Stocker les informations de l'utilisateur
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Fusionner le panier temporaire avec le panier de l'utilisateur
                if (!empty($temporaryCart)) {
                    $cartModel = new Cart();
                    $cartModel->mergeCart($user['id'], $temporaryCart);
                    unset($_SESSION['cart']); // Supprimer le panier temporaire
                }
                
                header('Location: /vent/index.php');
                exit;
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
                require __DIR__ . '/../views/users/utilisateur.php';
            }
        } else {
            require __DIR__ . '/../views/users/utilisateur.php';
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifier si l'utilisateur existe déjà
            if (User::findByUsername($username)) {
                $error = "Ce nom d'utilisateur est déjà pris.";
                require __DIR__ . '/../views/users/register.php';
                return;
            }

            // Créer un nouvel utilisateur
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

            if ($user->save()) {
                header('Location: /e-commerce/utilisateur.php');
                exit;
            } else {
                $error = "Erreur lors de l'inscription. Veuillez réessayer.";
                require __DIR__ . '/../views/users/register.php';
            }
        } else {
            require __DIR__ . '/../views/users/register.php';
        }
    }

    public function addAddress()
    {
        // Vérifier si l'utilisateur est connecté
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /vent/index.php?url=user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $address = new Address();
            $address->setFirstName($_POST['first_name']);
            $address->setLastName($_POST['last_name']);
            $address->setStreet($_POST['street']);
            $address->setPostalCode($_POST['postal_code']);
            $address->setPhone($_POST['phone']);
            $address->setUserId($_SESSION['user_id']);

            if ($address->save()) {
                header('Location: /vent/index.php');
                exit;
            } else {
                $error = "Erreur lors de l'enregistrement de l'adresse.";
                require __DIR__ . '/../views/address/add.php';
            }
        } else {
            require __DIR__ . '/../views/address/add.php';
        }
    }
}