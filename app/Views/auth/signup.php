<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Mobile Money</title>
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
                <div class="auth-hero__eyebrow">Création de compte</div>
                <h1 class="auth-hero__title">Rejoignez Mobile Money et accédez aux services opérateur et client.</h1>
                <p class="auth-hero__text">Une inscription plus claire, guidée par Bootstrap, avec les contrôles de saisie déjà présents dans le projet.</p>
                <div class="auth-hero__chips">
                    <span class="chip">Saisie assistée</span>
                    <span class="chip">Validation visuelle</span>
                    <span class="chip">Interface responsive</span>
                </div>
            </article>

            <section class="auth-card card shadow-lg border-0">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <p class="text-uppercase text-secondary fw-semibold mb-1 small">Inscription</p>
                        <h1 class="h3 fw-bold mb-2">Étape 1 - Informations de base</h1>
                        <p class="text-secondary mb-0">Remplissez vos informations personnelles pour continuer la création du compte.</p>
                    </div>

                    <?php if (isset($errors) && is_array($errors) && count($errors) > 0): ?>
                        <div class="alert alert-danger border-0 rounded-4 mb-4" role="alert">
                            <div class="fw-bold mb-2">Erreurs détectées</div>
                            <ul class="alert-list mb-0">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form id="signup" action="/showSignUp2" method="post" class="row g-3">
                        <?= csrf_field() ?>

                        <div class="col-12">
                            <label for="nom" class="form-label fw-semibold">Nom complet</label>
                            <input type="text" id="nom" name="nom" class="form-control form-control-lg" placeholder="Ex: RABARY" required value="<?= isset($old['nom']) ? esc($old['nom']) : '' ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Genre</label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" id="male" name="genre" value="M" required <?= (isset($old['genre']) && $old['genre'] === 'M') ? 'checked' : '' ?>>
                                    <span>Masculin</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" id="femelle" name="genre" value="F" <?= (isset($old['genre']) && $old['genre'] === 'F') ? 'checked' : '' ?>>
                                    <span>Féminin</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label fw-semibold">Adresse email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="exemple@domaine.com" required value="<?= isset($old['email']) ? esc($old['email']) : '' ?>">
                        </div>

                        <div class="col-12">
                            <label for="mdp" class="form-label fw-semibold">Mot de passe</label>
                            <div class="password-row">
                                <div class="password-field">
                                    <input id="mdp" type="password" name="password" class="form-control form-control-lg" placeholder="Créez un mot de passe sécurisé" minlength="8" required>
                                </div>
                                <button id="bouton" type="button" class="btn btn-outline-secondary btn-lg rounded-pill">Afficher</button>
                            </div>
                            <div class="form-text">Utilisez au moins 8 caractères pour renforcer l'accès à votre compte.</div>
                        </div>

                        <div class="col-12 d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Suivant</button>
                            <a href="/" class="btn btn-outline-secondary btn-lg rounded-pill">Se connecter</a>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>
</body>
</html>