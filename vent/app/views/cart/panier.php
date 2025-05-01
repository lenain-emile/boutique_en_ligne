<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <style>
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }
        .cart-item-details {
            flex-grow: 1;
        }
        .cart-total {
            margin-top: 20px;
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
        }
        .empty-cart {
            text-align: center;
            padding: 40px;
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
        .cart-actions {
            margin-top: 20px;
            text-align: right;
        }
        .clear-cart-button {
            padding: 8px 16px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .clear-cart-button:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <a href="/vent/products/vetements-femme" class="back-button">← Retour aux produits</a>
        <h1>Mon Panier</h1>
        
        <?php if (!empty($cartItems)): ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <?php if (!empty($item['image_url'])): ?>
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                    <?php endif; ?>
                    
                    <div class="cart-item-details">
                        <h3><?= htmlspecialchars($item['product_name']) ?></h3>
                        <p>Taille : <?= htmlspecialchars($item['size_label']) ?></p>
                        <p>Quantité : <?= $item['quantity'] ?></p>
                        <p>Prix unitaire : <?= number_format($item['price'], 2, ',', ' ') ?> €</p>
                        <p>Sous-total : <?= number_format($item['price'] * $item['quantity'], 2, ',', ' ') ?> €</p>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="cart-total">
                Total : <?= number_format($total, 2, ',', ' ') ?> €
            </div>
            <div class="cart-actions">
                <form action="/vent/cart/clear" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir vider votre panier ?');">
                    <button type="submit" class="clear-cart-button">Vider le panier</button>
                </form>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <p>Votre panier est vide</p>
                <a href="/vent/products/vetements-femme">Continuer vos achats</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
