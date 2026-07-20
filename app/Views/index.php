<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/css/operateur.css" rel="stylesheet">
</head>

<body class="op-body d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="text-center mb-5">
            <i class="bi bi-wallet2 fs-1 text-success"></i>
            <h1 class="op-page-title h3 mt-2">Bienvenue</h1>
            <p class="text-muted">Choisissez votre espace pour continuer</p>
        </div>

        <div class="row justify-content-center g-3">
            <div class="col-10 col-sm-6 col-md-4">
                <a href="/loginOperateur" class="op-quick-action flex-column text-center py-4">
                    <span class="op-quick-icon mb-2"><i class="bi bi-broadcast"></i></span>
                    <span class="fw-semibold">Espace Operateur</span>
                    <span class="small text-muted">Gerer prefixes, frais et clients</span>
                </a>
            </div>
            <div class="col-10 col-sm-6 col-md-4">
                <a href="/loginClient" class="op-quick-action flex-column text-center py-4">
                    <span class="op-quick-icon mb-2"><i class="bi bi-person"></i></span>
                    <span class="fw-semibold">Espace Client</span>
                    <span class="small text-muted">Depot, retrait et transfert</span>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
