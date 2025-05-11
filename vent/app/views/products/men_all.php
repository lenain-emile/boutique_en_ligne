<?php include_once __DIR__ . '/../layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vêtements pour hommes</title>
    <link rel="stylesheet" href="/vent/public/assets/style/category-filter.css">
</head>
<body>
    <div class="product-detail">
        <h1>Vêtements pour hommes</h1>

        <!-- Filtre de catégories -->
        <div class="category-filter">
            <form method="GET" action="/vent/products/vetements-homme">
                <select name="category">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Filtrer</button>
            </form>
        </div>

        <?php if (!empty($products)): ?>
            <ul class="product-list">
                <?php foreach ($products as $product): ?>
                    <li class="product-item">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image" />
                        <?php endif; ?>
                        
                        <h2><?= htmlspecialchars($product['name']) ?></h2>
                        <p class="description"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="price"><?= number_format($product['price'], 2, ',', ' ') ?> €</div>
                        
                        <a href="/vent/products/vetements-homme/<?= $product['id'] ?>" class="back-button">Voir détails</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun vêtement pour homme trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>
