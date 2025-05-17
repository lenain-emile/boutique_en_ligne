<?php
namespace App\Controllers;

use App\Models\Products;
use App\Models\ProductsMen;
use App\Models\Sizes;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;

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
        $sizesModel = new Sizes();
        
        // Récupérer tous les produits
        $womenProducts = $productModel->getAllProducts();
        $menProducts = $productMenModel->getAllProducts();
        
        // Récupérer toutes les catégories
        $categories = $productModel->getAllCategories();
        
        include_once __DIR__ . '/../views/admin/products.php';
    }

    public function addProduct() {
        $productModel = new Products();
        $sizesModel = new Sizes();
        
        // Récupérer toutes les catégories et tailles
        $categories = $productModel->getAllCategories();
        $sizes = $sizesModel->getAllSizes();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $categoryId = $_POST['category_id'];
            $genderId = $_POST['gender_id'];
            $selectedSizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];
            $stocks = isset($_POST['stocks']) ? $_POST['stocks'] : [];
            
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
            
            // Ajouter le produit et ses tailles
            $productId = $productModel->addProduct($name, $description, $price, $image, $categoryId, $genderId);
            
            // Ajouter les tailles sélectionnées pour ce produit
            if ($productId && !empty($selectedSizes)) {
                $productModel->addProductSizes($productId, $selectedSizes);
                
                // Mettre à jour les stocks pour chaque taille
                foreach ($stocks as $sizeId => $quantity) {
                    if (in_array($sizeId, $selectedSizes)) {
                        $productModel->updateStock($productId, $sizeId, $quantity);
                    }
                }
            }
            
            header('Location: /vent/index.php?url=admin/products');
            exit;
        }
        
        include_once __DIR__ . '/../views/admin/add_product.php';
    }

    public function editProduct($id) {
        $productModel = new Products();
        $sizesModel = new Sizes();
        
        $product = $productModel->getProductById($id);
        
        // Récupérer toutes les catégories et tailles
        $categories = $productModel->getAllCategories();
        $sizes = $sizesModel->getAllSizes();
        
        // Récupérer les tailles actuelles du produit avec leurs stocks
        $productSizes = $productModel->getProductSizes($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $categoryId = $_POST['category_id'];
            $genderId = $_POST['gender_id'];
            $selectedSizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];
            $stocks = isset($_POST['stocks']) ? $_POST['stocks'] : [];
            
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
            
            // Mettre à jour les tailles et les stocks du produit
            $productModel->updateProductSizes($id, $selectedSizes);
            
            // Mettre à jour les stocks pour chaque taille
            foreach ($stocks as $sizeId => $quantity) {
                $productModel->updateStock($id, $sizeId, $quantity);
            }
            
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

    public function orders() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier si l'utilisateur est connecté et est admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /vent/index.php?url=user/login');
            exit;
        }

        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();
        
        include_once __DIR__ . '/../views/admin/orders.php';
    }

    public function updateOrderStatus() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier si l'utilisateur est connecté et est admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /vent/index.php?url=user/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if ($orderId && $status) {
                $orderModel = new Order();
                $orderModel->updateOrderStatus($orderId, $status);
            }
        }

        // Rediriger vers la page des commandes
        header('Location: /vent/index.php?url=admin/orders');
        exit;
    }
} 