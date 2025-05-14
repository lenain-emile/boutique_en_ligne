<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/vent/public/assets/style/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Connexion</h1>
            <p>Bienvenue sur W.E NAME</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/vent/index.php?url=user/login" class="auth-form">
            <div class="form-group">
                <label for="username">Pseudo</label>
                <input type="text" id="username" name="username" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="auth-button">Se connecter</button>
        </form>
        
        <div class="auth-links">
            <p>Pas encore inscrit ? <a href="/vent/index.php?url=user/register">Créer un compte</a></p>
        </div>
    </div>
</body>
</html>