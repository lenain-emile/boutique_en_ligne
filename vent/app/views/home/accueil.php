<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W.E NAME - Accueil</title>
    <link rel="stylesheet" href="/vent/public/assets/style/home.css">
</head>
<body>
    <div class="home-container">
        <section class="hero-section">
            <h1>Lume Studio</h1>
            <p>Découvrez notre collection de vêtements</p>
        </section>

        <section class="category-section">
            <div class="category-header">
                <h2>Collection Femme</h2>
                <a href="/vent/index.php?url=products/vetements-femme" class="view-all">Voir tout →</a>
            </div>
            <div class="product-grid">
                <?php
                // Mélanger les produits femme aléatoirement
                shuffle($womenProducts);
                // Prendre les 4 premiers produits
                $randomWomenProducts = array_slice($womenProducts, 0, 4);
                foreach ($randomWomenProducts as $product): ?>
                    <a href="/vent/products/vetements-femme/<?= $product['id'] ?>" class="product-card">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                        <?php endif; ?>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <div class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="category-section">
            <div class="category-header">
                <h2>Collection Homme</h2>
                <a href="/vent/index.php?url=products/vetements-homme" class="view-all">Voir tout →</a>
            </div>
            <div class="product-grid">
                <?php
                // Mélanger les produits homme aléatoirement
                shuffle($menProducts);
                // Prendre les 4 premiers produits
                $randomMenProducts = array_slice($menProducts, 0, 4);
                foreach ($randomMenProducts as $product): ?>
                    <a href="/vent/products/vetements-homme/<?= $product['id'] ?>" class="product-card">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                        <?php endif; ?>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <div class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>