<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="auth-app">
    <main class="auth-shell">
        <section class="auth-grid">
            <article class="auth-hero card shadow-lg border-0">
                <div class="auth-hero__eyebrow">Plateforme Mobile Money</div>
                <h1 class="auth-hero__title">Choisissez votre espace et accédez à l'application.</h1>
                <p class="auth-hero__text">Une entrée simple vers les deux parcours existants du projet, avec le même langage visuel Bootstrap que le reste de l'interface.</p>
                <div class="auth-hero__chips">
                    <span class="chip">Opérateur</span>
                    <span class="chip">Client</span>
                    <span class="chip">Responsive</span>
                </div>
            </article>

            <section class="auth-card card shadow-lg border-0">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <p class="text-uppercase text-secondary fw-semibold mb-1 small">Entrée rapide</p>
                        <h2 class="h3 fw-bold mb-2">Sélectionnez votre profil</h2>
                        <p class="text-secondary mb-0">Les accès sont séparés pour garder les parcours clairs et sécurisés.</p>
                    </div>

                    <div class="d-grid gap-3">
                        <a href="/loginOperateur" class="btn btn-primary btn-lg rounded-pill">Espace opérateur</a>
                        <a href="/loginClient" class="btn btn-outline-secondary btn-lg rounded-pill">Espace client</a>
                    </div>
                </div>
            </section>
        </section>
    </main>
</body>
</html>