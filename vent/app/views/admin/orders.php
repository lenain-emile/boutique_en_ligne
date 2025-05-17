<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes - Admin</title>
    <link rel="stylesheet" href="/vent/public/assets/style/admin-dashboard.css">
    <style>
        .orders-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .order-card {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .order-info {
            margin-bottom: 15px;
        }
        .order-info p {
            margin: 5px 0;
            color: #666;
        }
        .order-items {
            margin-top: 15px;
        }
        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .order-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
        }
        .order-total {
            text-align: right;
            font-weight: bold;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        .order-status {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 0.9em;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .admin-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .update-status-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .update-status-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="orders-container">
        <div class="header-actions">
            <h1>Gestion des Commandes</h1>
            <div class="action-buttons">
                <a href="/vent/index.php" class="home-btn">Retour à l'accueil</a>
                <a href="/vent/index.php?url=admin/produits" class="add-product-btn">Gérer les produits</a>
            </div>
        </div>
        
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h3>Commande #<?= $order['id'] ?></h3>
                            <p>Date: <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
                        </div>
                        <div>
                            <span class="order-status status-<?= strtolower($order['status']) ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="order-info">
                        <h4>Client</h4>
                        <p>Nom d'utilisateur: <?= htmlspecialchars($order['username']) ?></p>
                        <h4>Adresse de livraison</h4>
                        <p>
                            <?= htmlspecialchars($order['first_name']) ?> <?= htmlspecialchars($order['last_name']) ?><br>
                            <?= htmlspecialchars($order['street']) ?><br>
                            <?= htmlspecialchars($order['postal_code']) ?><br>
                            Tél: <?= htmlspecialchars($order['phone']) ?>
                        </p>
                    </div>
                    
                    <div class="order-items">
                        <h4>Articles commandés</h4>
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="order-item">
                                <?php if (!empty($item['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                <?php endif; ?>
                                <div>
                                    <h5><?= htmlspecialchars($item['product_name']) ?></h5>
                                    <p>Taille: <?= htmlspecialchars($item['size_label']) ?></p>
                                    <p>Quantité: <?= $item['quantity'] ?></p>
                                    <p>Prix unitaire: <?= number_format($item['unit_price'], 2, ',', ' ') ?> €</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="order-total">
                        Total: <?= number_format($order['total'], 2, ',', ' ') ?> €
                    </div>

                    <div class="admin-actions">
                        <form action="/vent/index.php?url=admin/update-order-status" method="POST" style="display: inline;">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="status" onchange="this.form.submit()" class="update-status-btn">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Complétée</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Annulée</option>
                            </select>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune commande n'a été passée.</p>
        <?php endif; ?>
    </div>
</body>
</html> 