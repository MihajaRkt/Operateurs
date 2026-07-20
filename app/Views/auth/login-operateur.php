<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion opérateur</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="/assets/js/main.js" defer></script>
</head>
<body class="auth-app">
    <main class="auth-shell">
        <section class="auth-grid">
            <article class="auth-hero card shadow-lg border-0">
                <div class="auth-hero__eyebrow">Espace opérateur</div>
                <h1 class="auth-hero__title">Gérez vos frais, préfixes et opérations depuis un tableau de bord clair.</h1>
                <p class="auth-hero__text">Une interface Bootstrap plus propre, pensée pour accéder rapidement aux actions les plus utilisées.</p>
                <div class="auth-hero__chips">
                    <span class="chip">Sidebar rapide</span>
                    <span class="chip">Formulaires guidés</span>
                    <span class="chip">Lecture immédiate</span>
                </div>
            </article>

            <section class="auth-card card shadow-lg border-0">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <p class="text-uppercase text-secondary fw-semibold mb-1 small">Connexion</p>
                        <h1 class="h3 fw-bold mb-2">Accédez à votre espace opérateur</h1>
                        <p class="text-secondary mb-0">Saisissez votre numéro opérateur pour ouvrir le tableau de bord.</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger border-0 rounded-4 mb-4" role="alert">
                            <?= esc($error) ?>
                        </div>
                    <?php endif; ?>

                    <form action="/loginOperateur" method="post" class="row g-3">
                        <div class="col-12">
                            <label for="numero" class="form-label fw-semibold">Numéro opérateur</label>
                            <input
                                type="tel"
                                class="form-control form-control-lg"
                                id="numero"
                                name="numero"
                                inputmode="numeric"
                                maxlength="12"
                                placeholder="Ex: 0320000000"
                                required>
                            <div class="form-text">Le numéro doit contenir entre 10 et 12 chiffres.</div>
                        </div>

                        <div class="col-12 d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Se connecter</button>
                            <a href="/" class="btn btn-outline-secondary btn-lg rounded-pill">Retour à l'accueil</a>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>
</body>
</html>