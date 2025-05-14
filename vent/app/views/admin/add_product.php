<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="/vent/public/assets/style/admin-dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un Nouveau Produit</h1>
        
        <div class="form-container">
            <form action="/vent/index.php?url=admin/ajouter-produit" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nom du produit</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Prix</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Catégorie</label>
                    <select id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="gender_id">Genre</label>
                    <select id="gender_id" name="gender_id" required>
                        <option value="1">Homme</option>
                        <option value="2">Femme</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tailles disponibles</label>
                    <div class="sizes-container">
                        <?php foreach ($sizes as $size): ?>
                            <div class="size-checkbox">
                                <input type="checkbox" id="size_<?= $size['id'] ?>" name="sizes[]" value="<?= $size['id'] ?>">
                                <label for="size_<?= $size['id'] ?>"><?= htmlspecialchars($size['label']) ?></label>
                                <input type="number" name="stocks[<?= $size['id'] ?>]" value="0" min="0" class="stock-input" placeholder="Stock">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Image du produit</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                
                <button type="submit" class="submit-btn">Ajouter le produit</button>
            </form>
        </div>
    </div>
</body>
</html> 