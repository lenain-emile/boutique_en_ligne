<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une adresse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Ajouter une adresse</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/e-commerce/index.php?url=address/add">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Prénom :</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Nom :</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="street" class="form-label">Rue :</label>
                                <input type="text" id="street" name="street" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="postal_code" class="form-label">Code postal :</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Téléphone :</label>
                                <input type="tel" id="phone" name="phone" class="form-control">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Enregistrer l'adresse</button>
                            </div>
                        </form>
                        <?php if (isset($error)) echo "<div class='alert alert-danger mt-3'>$error</div>"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>