<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier</title>
    <link rel="stylesheet" href="/vent/public/assets/style/cart.css">
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
                <form action="/vent/index.php?url=cart/vider" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir vider votre panier ?');">
                    <button type="submit" class="clear-cart-button">Vider le panier</button>
                </form>
                <a href="/vent/index.php?url=panier/select-address" class="pay-cart-button">Payer</a>
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
