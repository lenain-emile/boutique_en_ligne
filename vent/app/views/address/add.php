<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une adresse - W.E NAME</title>
    <link rel="stylesheet" href="/vent/public/assets/style/address.css">
</head>
<body>
    <div class="container">
        <a href="/vent/index.php" class="home-btn">← Retour à l'accueil</a>
        
        <div class="card">
            <div class="card-header">
                <h3>Ajouter une adresse</h3>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="/vent/index.php?url=address/add">
                <div class="form-group">
                    <label for="first_name">Prénom</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Nom</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                
                <div class="form-group">
                    <label for="street">Rue</label>
                    <input type="text" id="street" name="street" required>
                </div>
                
                <div class="form-group">
                    <label for="postal_code">Code postal</label>
                    <input type="text" id="postal_code" name="postal_code" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <button type="submit" class="btn-primary">Enregistrer l'adresse</button>
            </form>
        </div>
    </div>
</body>
</html>