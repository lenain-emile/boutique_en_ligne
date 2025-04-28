<?php

// Récupérer l'URL depuis la requête
$url = '';
if (isset($_GET['url'])) {
    // Exploser l'URL en tableau
    $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
    // ici  explode est utilisé pour séparer  les  segments de l'URL  le delimiteur est le caractère '/'. sinon je peux utiliser  '-' avec preg_matchh '
}

// Récupérer la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Contrôler la première valeur de l'URL
if (empty($url[0]) || $url[0] == 'accueil') {
    // Si l'URL est vide ou correspond à "accueil", afficher la page d'accueil
    require_once 'app/views/home/accueil.php';
} else if ($url[0] == 'products') {
    // Si l'URL correspond à "produits" gérer les produits
   echo 'w.e je sais pas quoi mettre ici';  
} else if ($url[0] == 'categorie') {
    // Si l'URL correspond à "categorie" gérer les catégories
    if ($method == 'GET') {
        echo 'Afficher les catégories';
    }
} else if ($url[0] == 'produit') {
    // Si l'URL correspond à "produit" afficher un produit spécifique
    if ($method == 'GET') {
        echo 'Afficher un produit spécifique';
    }
} else {
    // Si aucune correspondance afficher une erreur 404
    require_once 'app/router/erreur404.html';   
}
 
