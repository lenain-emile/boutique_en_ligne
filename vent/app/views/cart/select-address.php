<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sélection de l'adresse de livraison</title>
    <link rel="stylesheet" href="/vent/public/assets/style/cart.css">
</head>
<body>
    <div class="cart-container">
        <a href="/vent/index.php?url=panier/voir" class="back-button">← Retour au panier</a>
        <h1>Sélection de l'adresse de livraison</h1>
        
        <?php if (!empty($addresses)): ?>
            <div class="addresses-list">
                <?php foreach ($addresses as $address): ?>
                    <div class="address-card">
                        <div class="address-details">
                            <h3><?= htmlspecialchars($address['first_name']) ?> <?= htmlspecialchars($address['last_name']) ?></h3>
                            <p><?= htmlspecialchars($address['street']) ?></p>
                            <p><?= htmlspecialchars($address['postal_code']) ?></p>
                            <p>Tél: <?= htmlspecialchars($address['phone']) ?></p>
                        </div>
                        <form action="/vent/index.php?url=panier/payer" method="POST">
                            <input type="hidden" name="address_id" value="<?= $address['id'] ?>">
                            <button type="submit" class="select-address-btn">Sélectionner cette adresse</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-address">
                <p>Vous n'avez pas encore d'adresse enregistrée.</p>
                <a href="/vent/index.php?url=address/add" class="add-address-btn">Ajouter une adresse</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 