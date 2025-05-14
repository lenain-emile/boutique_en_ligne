<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="/vent/public/assets/style/admin-dashboard.css">
</head>
<body>
    <div class="container">
        <div class="header-actions">
            <h1>Gestion des Produits</h1>
            <div class="action-buttons">
                <a href="/vent/index.php" class="home-btn">Retour à l'accueil</a>
                <a href="/vent/index.php?url=admin/ajouter-produit" class="add-product-btn">Ajouter un nouveau produit</a>
            </div>
        </div>
        
        <h2>Produits Femme</h2>
        <div class="product-grid">
            <?php foreach ($womenProducts as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                    <p>Prix: <?= number_format($product['price'], 2, ',', ' ') ?> €</p>
                    <div class="stock-info">
                        <h4>Stocks par taille :</h4>
                        <?php
                        $productSizes = $productModel->getProductSizes($product['id']);
                        foreach ($productSizes as $sizeInfo):
                            $size = $sizesModel->getSizeById($sizeInfo['size_id']);
                        ?>
                            <p><?= htmlspecialchars($size['label']) ?>: <?= $sizeInfo['stock'] ?></p>
                        <?php endforeach; ?>
                    </div>
                    <div class="admin-actions">
                        <a href="/vent/index.php?url=admin/modifier-produit/<?= $product['id'] ?>" class="edit-btn">Modifier</a>
                        <a href="/vent/index.php?url=admin/supprimer-produit/<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Produits Homme</h2>
        <div class="product-grid">
            <?php foreach ($menProducts as $product): ?>
                <div class="product-card">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                    <p>Prix: <?= number_format($product['price'], 2, ',', ' ') ?> €</p>
                    <div class="stock-info">
                        <h4>Stocks par taille :</h4>
                        <?php
                        $productSizes = $productModel->getProductSizes($product['id']);
                        foreach ($productSizes as $sizeInfo):
                            $size = $sizesModel->getSizeById($sizeInfo['size_id']);
                        ?>
                            <p><?= htmlspecialchars($size['label']) ?>: <?= $sizeInfo['stock'] ?></p>
                        <?php endforeach; ?>
                    </div>
                    <div class="admin-actions">
                        <a href="/vent/index.php?url=admin/modifier-produit/<?= $product['id'] ?>" class="edit-btn">Modifier</a>
                        <a href="/vent/index.php?url=admin/supprimer-produit/<?= $product['id'] ?>" class="delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 