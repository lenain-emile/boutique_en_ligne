<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Produit</title>
    <link rel="stylesheet" href="/vent/public/assets/style/admin-dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Modifier le Produit</h1>
        
        <div class="form-container">
            <form action="/vent/index.php?url=admin/modifier-produit/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nom du produit</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Prix</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?= $product['price'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Catégorie</label>
                    <select id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="gender_id">Genre</label>
                    <select id="gender_id" name="gender_id" required>
                        <option value="1" <?= $product['gender_id'] == 1 ? 'selected' : '' ?>>Homme</option>
                        <option value="2" <?= $product['gender_id'] == 2 ? 'selected' : '' ?>>Femme</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tailles disponibles</label>
                    <div class="sizes-container">
                        <?php foreach ($sizes as $size): ?>
                            <div class="size-checkbox">
                                <input type="checkbox" id="size_<?= $size['id'] ?>" name="sizes[]" value="<?= $size['id'] ?>"
                                    <?= in_array($size['id'], array_column($productSizes, 'size_id')) ? 'checked' : '' ?>>
                                <label for="size_<?= $size['id'] ?>"><?= htmlspecialchars($size['label']) ?></label>
                                <input type="number" name="stocks[<?= $size['id'] ?>]" 
                                       value="<?= isset($productSizes[array_search($size['id'], array_column($productSizes, 'size_id'))]) ? 
                                              $productSizes[array_search($size['id'], array_column($productSizes, 'size_id'))]['stock'] : 0 ?>" 
                                       min="0" class="stock-input" placeholder="Stock">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Image actuelle</label>
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Image actuelle" class="current-image">
                    <?php endif; ?>
                    <label for="image">Nouvelle image (laisser vide pour conserver l'image actuelle)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                
                <button type="submit" class="submit-btn">Mettre à jour le produit</button>
            </form>
        </div>
    </div>
</body>
</html> 