<?php
namespace App\Controllers;

use App\Models\Products;

class ProductController {
    public function showWomenall() {
        $productModel = new Products();
        $products = $productModel->getAllProducts();
        include_once __DIR__ . '/../views/products/women_all.php';
    }

    public function showProductDetail($id) {
        $productModel = new Products();
    
        // Récupérer les détails du produit par ID et genre
        $product = $productModel->getProductById($id);
    
        if ($product) {
            // Récupérer les tailles disponibles pour ce produit
            $sizes = $productModel->getSizesByProductId($id);
            include_once __DIR__ . '/../views/products/detail.php';
        } else {
            // Si le produit n'existe pas ou n'a pas le genre 2, rediriger l'utilisateur
            header('Location: /vent/products/vetements-femme');
            exit;
        }
    }
}
