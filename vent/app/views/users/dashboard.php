<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: /vent/index.php?url=user/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - W.E NAME</title>
    <link rel="stylesheet" href="/vent/public/assets/style/dashboard.css">
</head>
<body>
    <div class="container">
        <a href="/vent/index.php" class="home-btn">← Retour à l'accueil</a>
        
        <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        
        <div class="dashboard-menu">
            <h2>Menu</h2>
            <ul>
                <li><a href="/vent/index.php?url=address/add">Ajouter une adresse</a></li>
                <li><a href="/vent/index.php?url=panier/voir">Voir mon panier</a></li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="/vent/index.php?url=admin/produits">Gérer les produits</a></li>
                <?php endif; ?>
                <li><a href="/vent/index.php?url=user/logout">Déconnexion</a></li>
            </ul>
        </div>
    </div>
</body>
</html> 