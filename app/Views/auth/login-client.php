<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion client</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="auth-app">
    <main class="auth-shell">
        <section class="auth-grid">
            <article class="auth-hero card shadow-lg border-0">
                <div class="auth-hero__eyebrow">Espace client</div>
                <h1 class="auth-hero__title">Connectez-vous avec votre numéro pour accéder à votre compte.</h1>
                <p class="auth-hero__text">Le formulaire conserve une saisie simple pour rester compatible avec la logique actuelle du projet.</p>
                <div class="auth-hero__chips">
                    <span class="chip">Connexion</span>
                    <span class="chip">Compte client</span>
                    <span class="chip">Sécurisé</span>
                </div>
            </article>

            <section class="auth-card card shadow-lg border-0">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <p class="text-uppercase text-secondary fw-semibold mb-1 small">Connexion</p>
                        <h1 class="h3 fw-bold mb-2">Accédez à votre espace client</h1>
                        <p class="text-secondary mb-0">Saisissez votre numéro de téléphone pour ouvrir votre tableau de bord.</p>
                    </div>

                    <form action="/clientLogin" method="post" class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="numero">Numéro</label>
                            <input type="tel" class="form-control form-control-lg" id="numero" name="numero" minlength="10" maxlength="12" inputmode="numeric" placeholder="0320000000" value="0320000000">
                            <div class="form-text">Le numéro doit contenir au moins 10 chiffres.</div>
                        </div>

                        <div class="col-12 d-grid gap-2">
                            <input type="submit" class="btn btn-primary btn-lg rounded-pill" value="Confirmer">
                            <a href="/" class="btn btn-outline-secondary btn-lg rounded-pill">Retour à l'accueil</a>
                        </div>
                    </form>

                    <?php if (session()->getFlashdata('erreur')) : ?>
	                    <div class="alert alert-danger border-0 rounded-4 mt-4 mb-0">
	                        <?= session()->getFlashdata('erreur') ?>
	                    </div>
	                <?php endif; ?>
                </div>
            </section>
        </section>
    </main>
</body>
</html>