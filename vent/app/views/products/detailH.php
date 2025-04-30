<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du produit</title>
</head>
<body>
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <p><strong>Description :</strong> <?= htmlspecialchars($product['description']) ?></p>
    <p><strong>Prix :</strong> <?= number_format($product['price'], 2, ',', ' ') ?> €</p>

    <!-- Affichage de l'image du produit -->
    <?php if (!empty($product['image'])): ?>
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width: 100%; height: auto;" />
    <?php else: ?>
        <p>Aucune image disponible pour ce produit.</p>
    <?php endif; ?>

    <a href="/vent/products/vetements-homme">← Retour</a>



    <h3>Tailles disponibles :</h3>
    <?php if (!empty($sizes)): ?>
        <ul>
            <?php foreach ($sizes as $size): ?>
                <li><?= htmlspecialchars($size['label']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune taille disponible.</p>
    <?php endif; ?>

</body>
</html>
