<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt</title>
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
                <div class="auth-hero__eyebrow">Opération client</div>
                <h1 class="auth-hero__title">Effectuez un dépôt sur votre compte en quelques secondes.</h1>
                <p class="auth-hero__text">La saisie est volontairement simple pour rester compatible avec la logique actuelle du projet.</p>
                <div class="auth-hero__chips">
                    <span class="chip">Montant</span>
                    <span class="chip">Date</span>
                    <span class="chip">Sécurisé</span>
                </div>
            </article>

            <section class="auth-card card shadow-lg border-0">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <p class="text-uppercase text-secondary fw-semibold mb-1 small">Dépôt</p>
                        <h1 class="h3 fw-bold mb-2">Faire un dépôt</h1>
                        <p class="text-secondary mb-0">Renseignez le montant et la date de l'opération.</p>
                    </div>

                    <?php if (session()->getFlashdata('erreur')) : ?>
                        <div class="alert alert-danger border-0 rounded-4 mb-3">
                            <?= session()->getFlashdata('erreur') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erreur)) : ?>
                        <div class="alert alert-danger border-0 rounded-4 mb-3">
                            <?= esc($erreur) ?>
                        </div>
                    <?php endif; ?>

                    <form action="/depot/save" method="post" class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="montant">Montant</label>
                            <input type="number" class="form-control form-control-lg" name="montant" id="montant" min="1" step="0.01" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold" for="date">Date</label>
                            <input type="date" class="form-control form-control-lg" name="date" id="date" required>
                        </div>

                        <div class="col-12 d-grid gap-2">
                            <input type="submit" class="btn btn-primary btn-lg rounded-pill" value="Déposer">
                            <a href="/accueil" class="btn btn-outline-secondary btn-lg rounded-pill">Retour</a>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>
</body>
</html>