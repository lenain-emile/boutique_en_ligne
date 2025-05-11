<?php
namespace App\Controllers;

use App\Models\ProductsMen;

class ProductMenController {
    // Affiche tous les produits pour hommes
    public function showMenAll() {
        $productModel = new ProductsMen();
        $categories = $productModel->getAllCategories();
        
        // Récupérer la catégorie sélectionnée depuis l'URL
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        
        // Récupérer les produits en fonction de la catégorie sélectionnée
        $products = $categoryId ? $productModel->getProductsByCategory($categoryId) : $productModel->getAllProducts();
        
        include_once __DIR__ . '/../views/products/men_all.php';  // La vue affichant tous les produits des hommes
    }

    // Affiche les détails d'un produit pour homme
    public function showProductDetail($id) {
        $productModel = new ProductsMen();
        
        // Récupérer les détails du produit par ID pour les hommes
        $product = $productModel->getProductById($id);
        
        if ($product) {
            // Récupérer les tailles disponibles pour ce produit
            $sizes = $productModel->getSizesByProductId($id);
            include_once __DIR__ . '/../views/products/detailH.php';  // Vue des détails pour hommes
        } else {
            // Si le produit n'existe pas ou n'a pas le genre 1, rediriger l'utilisateur
            header('Location: /vent/products/vetements-homme');
            exit;
        }
    }
}
?>
