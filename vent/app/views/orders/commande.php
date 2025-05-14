<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes</title>
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
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
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
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .back-button:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="orders-container">
        <a href="/vent/index.php" class="back-button">← Retour à l'accueil</a>
        <h1>Mes Commandes</h1>
        
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
                    
                    <div class="order-address">
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
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Vous n'avez pas encore passé de commande.</p>
        <?php endif; ?>
    </div>
</body>
</html>


