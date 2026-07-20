<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Operateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/operateur.css" rel="stylesheet">
</head>

<body class="op-body d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-5 col-lg-4">
                <div class="op-card p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-broadcast fs-1 text-success"></i>
                        <h1 class="op-page-title h4 mt-2 mb-0">Espace Operateur</h1>
                        <p class="text-muted small mb-0">Connectez-vous pour continuer</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger py-2" role="alert">
                            <?= esc($error) ?>
                        </div>
                    <?php endif; ?>

                    <form action="/loginOperateur" method="post" class="op-needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="numero" class="form-label">Votre numero</label>
                            <input type="text" class="form-control" id="numero" name="numero" required
                                pattern="[0-9]+" inputmode="numeric" placeholder="Ex : 032" autofocus>
                            <div class="invalid-feedback">Merci d'entrer un numero valide (chiffres uniquement).</div>
                        </div>

                        <button type="submit" class="btn btn-op-primary w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
