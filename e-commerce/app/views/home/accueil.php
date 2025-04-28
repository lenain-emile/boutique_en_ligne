<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/index.php">Accueil</a></li>
                <li><a href="/products.php">Produits</a></li>
                <li><a href="/contact.php">Contact</a></li>
                <li><a href="/about.php">À propos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Bienvenue sur notre site e-commerce</h1>
            <p>Découvrez nos produits de qualité au meilleur prix.</p>
            <a href="/products.php" class="btn">Voir les produits</a>
        </section>

        <section class="featured-products">
            <h2>Produits phares</h2>
            <div class="product-list">
                <!-- Exemple de produit -->
                <div class="product-item">
                    <img src="/assets/images/product1.jpg" alt="Produit 1">
                    <h3>Produit 1</h3>
                    <p>Prix: 20€</p>
                    <a href="/product-details.php?id=1" class="btn">Voir le produit</a>
                </div>
                <!-- Ajouter d'autres produits ici -->
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 E-commerce. Tous droits réservés.</p>
    </footer>
</body>
</html>