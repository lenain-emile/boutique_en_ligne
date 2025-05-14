<?php
namespace App\Controllers;

use App\Models\Products;
use App\Models\ProductsMen;

class HomeController {
    public function index() {
        // Récupérer les produits femme
        $productModel = new Products();
        $womenProducts = $productModel->getAllProducts();

        // Récupérer les produits homme
        $productMenModel = new ProductsMen();
        $menProducts = $productMenModel->getAllProducts();

        // Inclure la vue
        include_once __DIR__ . '/../views/home/accueil.php';
    }
} 