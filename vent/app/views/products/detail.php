<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du produit</title>
    <link rel="stylesheet" href="/vent/public/assets/style/product-detail.css">
</head>
<body>
    <div class="product-detail">
        <a href="/vent/products/vetements-femme" class="back-link">← Retour</a>
        
        <div class="product-header">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
        </div>

        <div class="product-info">
            <div class="product-image-container">
                <?php if (!empty($product['image_url'])): ?>
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image" />
                <?php else: ?>
                    <div class="no-image">
                        <p>Aucune image disponible pour ce produit.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="product-details">
                <p class="product-description"><?= htmlspecialchars($product['description']) ?></p>
                <p class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</p>

                <div class="sizes-section">
                    <h3>Tailles disponibles :</h3>
                    <?php if (!empty($sizes)): ?>
                        <form action="/vent/index.php?url=panier/ajouter" method="POST" class="size-selector">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <select name="size_id" required>
                                <option value="">Sélectionnez une taille</option>
                                <?php foreach ($sizes as $size): ?>
                                    <option value="<?= $size['id'] ?>"><?= htmlspecialchars($size['label']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="add-to-cart-btn">Ajouter au panier</button>
                        </form>
                    <?php else: ?>
                        <p class="no-sizes">Aucune taille disponible.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
