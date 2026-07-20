<?php
$user = $user ?? (session()->get("user") ?? []);
$solde = $solde ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil client</title>
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
                <h1 class="auth-hero__title">Consultez votre solde et lancez vos opérations en toute simplicité.</h1>
                <p class="auth-hero__text">Le tableau client reprend le même langage visuel Bootstrap que l’espace opérateur pour rester lisible sur mobile comme sur desktop.</p>
                <div class="auth-hero__chips">
                    <span class="chip">Solde</span>
                    <span class="chip">Dépôt</span>
                    <span class="chip">Retrait</span>
                    <span class="chip">Transfert</span>
                </div>
            </article>

            <section class="auth-card card shadow-lg border-0">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <p class="text-uppercase text-secondary fw-semibold mb-1 small">Bienvenue</p>
                        <h1 class="h3 fw-bold mb-2">Bonjour <?= esc($user["nom"] ?? "") ?></h1>
                        <p class="text-secondary mb-0">Votre solde actuel est affiché ci-dessous avec les actions principales du compte.</p>
                    </div>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success border-0 rounded-4 mb-3">
                            <?= esc($success) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata("success")): ?>
	                    <div class="alert alert-success border-0 rounded-4 mb-3">
		                    <?= session()->getFlashdata("success") ?>
	                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata("erreur")): ?>
	                    <div class="alert alert-danger border-0 rounded-4 mb-3">
		                    <?= session()->getFlashdata("erreur") ?>
	                    </div>
                    <?php endif; ?>

                    <div class="metric-card mb-4">
                        <div class="metric-label">Votre solde actuelle</div>
                        <div class="metric-value"><?= esc((string) $solde) ?></div>
                        <div class="metric-unit">Compte actif</div>
                    </div>

                    <div class="d-grid gap-3">
                        <a href="/transfert-form" class="btn btn-primary btn-lg rounded-pill">Faire un transfert</a>
                        <a href="/depot-form" class="btn btn-outline-secondary btn-lg rounded-pill">Faire un dépôt</a>
                        <a href="/retrait-form" class="btn btn-outline-secondary btn-lg rounded-pill">Faire un retrait</a>
                        <a href="/historique" class="btn btn-outline-secondary btn-lg rounded-pill">Mes actions</a>
                    </div>
                </div>
            </section>
        </section>
    </main>
</body>
</html>