<?php
namespace App\Controllers;

use App\Models\Products;
use App\Models\ProductsMen;

class AdminController {
    public function __construct() {
        // Vérifier si l'utilisateur est connecté et est un admin
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /vent/index.php?url=user/login');
            exit;
        }
    }

    public function products() {
        $productModel = new Products();
        $productMenModel = new ProductsMen();
        
        // Récupérer tous les produits
        $womenProducts = $productModel->getAllProducts();
        $menProducts = $productMenModel->getAllProducts();
        
        // Récupérer toutes les catégories
        $categories = $productModel->getAllCategories();
        
        include_once __DIR__ . '/../views/admin/products.php';
    }

    public function addProduct() {
        $productModel = new Products();
        
        // Récupérer toutes les catégories
        $categories = $productModel->getAllCategories();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $categoryId = $_POST['category_id'];
            $genderId = $_POST['gender_id'];
            
            // Gérer l'upload d'image
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/image/';
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = $fileName;
                }
            }
            
            // Ajouter le produit
            $productModel->addProduct($name, $description, $price, $image, $categoryId, $genderId);
            
            header('Location: /vent/index.php?url=admin/products');
            exit;
        }
        
        include_once __DIR__ . '/../views/admin/add_product.php';
    }

    public function editProduct($id) {
        $productModel = new Products();
        $product = $productModel->getProductById($id);
        
        // Récupérer toutes les catégories
        $categories = $productModel->getAllCategories();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $categoryId = $_POST['category_id'];
            $genderId = $_POST['gender_id'];
            
            // Gérer l'upload d'image
            $image = $product['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/image/';
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Supprimer l'ancienne image si elle existe
                    if (!empty($product['image'])) {
                        $oldImage = $uploadDir . $product['image'];
                        if (file_exists($oldImage)) {
                            unlink($oldImage);
                        }
                    }
                    $image = $fileName;
                }
            }
            
            // Mettre à jour le produit
            $productModel->updateProduct($id, $name, $description, $price, $image, $categoryId, $genderId);
            
            header('Location: /vent/index.php?url=admin/products');
            exit;
        }
        
        include_once __DIR__ . '/../views/admin/edit_product.php';
    }

    public function deleteProduct($id) {
        $productModel = new Products();
        $product = $productModel->getProductById($id);
        
        if ($product) {
            // Supprimer l'image si elle existe
            if (!empty($product['image'])) {
                $imagePath = __DIR__ . '/../../public/image/' . $product['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // Supprimer le produit
            $productModel->deleteProduct($id);
        }
        
        header('Location: /vent/index.php?url=admin/products');
        exit;
    }
} 