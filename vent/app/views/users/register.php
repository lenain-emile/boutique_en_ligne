<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/vent/public/assets/style/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Inscription</h1>
            <p>Créez votre compte W.E NAME</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/vent/index.php?url=user/register" class="auth-form">
            <div class="form-group">
                <label for="username">Pseudo</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="auth-button">S'inscrire</button>
        </form>
        
        <div class="auth-links">
            <p>Déjà inscrit ? <a href="/vent/index.php?url=user/login">Se connecter</a></p>
        </div>
    </div>
</body>
</html>