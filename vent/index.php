<?php
require_once 'app/config/autoloader.php';

// Récupérer l'URL depuis la requête
$url = '';
if (isset($_GET['url'])) {
    $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
}

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Contrôler la première valeur de l'URL
if (empty($url[0]) || $url[0] == 'accueil') {
    // Page d'accueil
    require_once 'app/views/home/accueil.php';

} else if ($url[0] == 'products') {
    // Gestion des produits
    if ($method == 'GET') {
        if (isset($url[1]) && $url[1] == 'vetements-femme') {
            // FEMME : /products/vetements-femme ou /products/vetements-femme/4
            $controller = new \App\Controllers\ProductController();

            if (isset($url[2]) && is_numeric($url[2])) {
                // Détail produit femme
                $controller->showProductDetail($url[2]);
            } else {
                // Liste des produits femme
                $controller->showWomenall();
            }
        } elseif (isset($url[1]) && $url[1] == 'vetements-homme') {
            // HOMME : /products/vetements-homme ou /products/vetements-homme/4
            $controller = new \App\Controllers\ProductMenController();

            if (isset($url[2]) && is_numeric($url[2])) {
                // Détail produit homme
                $controller->showProductDetail($url[2]);
            } else {
                // Liste des produits homme
                $controller->showMenAll();
            }
        } else {
            echo 'Liste générale des produits ou route non reconnue.';
        }
    }

} else if ($url[0] == 'panier') {
    // Gestion du panier
    $controller = new \App\Controllers\CartController();
    
    if (isset($url[1])) {
        if ($url[1] == 'add') {
            $controller->add();
        } else if ($url[1] == 'view') {
            $controller->view();
        } else {
            echo 'Action du panier non reconnue.';
        }
    } else {
        // Par défaut, afficher le panier
        $controller->view();
    }

} else if ($url[0] == 'categorie') {
    // Gestion des catégories
    if ($method == 'GET') {
        echo 'Afficher les catégories';
    }

} else if ($url[0] == 'produit') {
    // Route alternative : /produit/4 (si tu veux la garder)
    if ($method == 'GET' && isset($url[1])) {
        $productId = (int) $url[1];
        $controller = new \App\Controllers\ProductController();
        $controller->showProductDetail($productId);
    } else {
        echo 'ID du produit manquant.';
    }

} else {
    // Page 404
    require_once 'app/router/erreur404.html';
}
