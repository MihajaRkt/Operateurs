<?php
$user = $user ?? (session()->get('user') ?? []);
$userName = $user['nom'] ?? 'Opérateur';
$frais = $frais ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($frais) ? 'Modifier un frais' : 'Ajouter un frais' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="/assets/js/main.js" defer></script>
</head>
<body>
    <div class="sidebar-backdrop" data-sidebar-backdrop></div>
    <div class="operator-shell">
        <aside class="operator-sidebar">
            <div class="operator-sidebar__brand">
                <p class="operator-sidebar__brand-title mb-0">Mobile Money Opérateur</p>
                <p class="operator-sidebar__brand-subtitle">Créez et ajustez les grilles de frais utilisées par les opérations.</p>
            </div>

            <nav class="operator-sidebar__nav">
                <a href="/accueilOperateur" data-sidebar-link>
                    <span class="operator-sidebar__nav-icon">⌂</span>
                    <span>Tableau de bord</span>
                </a>
                <a href="/ajouterPrefixe" data-sidebar-link>
                    <span class="operator-sidebar__nav-icon">+</span>
                    <span>Ajouter un préfixe</span>
                </a>
                <a href="/ajouterFrais" data-sidebar-link>
                    <span class="operator-sidebar__nav-icon">%</span>
                    <span>Ajouter des frais</span>
                </a>
                <a href="/voirGain/<?= esc($userName) ?>" data-sidebar-link>
                    <span class="operator-sidebar__nav-icon">€</span>
                    <span>Voir les gains</span>
                </a>
                <a href="/compteClients/<?= esc($userName) ?>" data-sidebar-link>
                    <span class="operator-sidebar__nav-icon">👥</span>
                    <span>Voir les clients</span>
                </a>
            </nav>

            <div class="operator-sidebar__footer">
                <p class="mb-1 fw-semibold text-white">Connecté comme</p>
                <p class="mb-0"><?= esc($userName) ?></p>
            </div>
        </aside>

        <main class="operator-main">
            <header class="operator-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="sidebar-toggle" data-sidebar-toggle aria-label="Ouvrir le menu">☰</button>
                    <div>
                        <h1 class="operator-topbar__title"><?= !empty($frais) ? 'Modifier le frais' : 'Ajouter un frais' ?></h1>
                        <p class="operator-topbar__subtitle">Définissez des montants minimum, maximum et le frais associé.</p>
                    </div>
                </div>
                <div class="operator-topbar__actions">
                    <a class="btn btn-outline-secondary rounded-pill" href="/accueilOperateur">Retour au dashboard</a>
                </div>
            </header>

            <section class="operator-content">
                <div class="row g-4">
                    <div class="col-12 col-xl-7">
                        <div class="form-shell h-100">
                            <div class="mb-1">
                                <p class="text-uppercase text-secondary fw-semibold small mb-1">Formulaire</p>
                                <h2 class="section-title"><?= !empty($frais) ? 'Edition du frais' : 'Nouveau frais' ?></h2>
                                <p class="muted mt-2">Les champs numériques sont restreints pour limiter les erreurs de saisie côté interface.</p>
                            </div>

                            <?php if (!empty($frais)): ?>
                                <form action="/modifierFrais/<?= esc($frais['idFrais']) ?>" method="post" class="row g-3">
                                    <div class="col-12">
                                        <label for="desc" class="form-label">Description</label>
                                        <input type="text" class="form-control form-control-lg" id="desc" name="desc" value="<?= esc($frais['description']) ?>" minlength="3" maxlength="120" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="min" class="form-label">Montant min</label>
                                        <input type="number" class="form-control form-control-lg" id="min" name="min" min="0" step="0.01" value="<?= esc($frais['montantMin']) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="max" class="form-label">Montant max</label>
                                        <input type="number" class="form-control form-control-lg" id="max" name="max" min="0" step="0.01" value="<?= esc($frais['montantMax']) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="montant" class="form-label">Frais</label>
                                        <input type="number" class="form-control form-control-lg" id="montant" name="montant" min="0" step="0.01" value="<?= esc($frais['montant']) ?>" required>
                                    </div>
                                    <div class="col-12 d-grid d-sm-flex gap-2 mt-2">
                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Enregistrer les frais</button>
                                        <a href="/accueilOperateur" class="btn btn-outline-secondary btn-lg rounded-pill">Annuler</a>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form action="/ajouterFrais" method="post" class="row g-3">
                                    <div class="col-12">
                                        <label for="desc" class="form-label">Description</label>
                                        <input type="text" class="form-control form-control-lg" id="desc" name="desc" minlength="3" maxlength="120" placeholder="Ex: Retrait national" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="min" class="form-label">Montant min</label>
                                        <input type="number" class="form-control form-control-lg" id="min" name="min" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="max" class="form-label">Montant max</label>
                                        <input type="number" class="form-control form-control-lg" id="max" name="max" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="montant" class="form-label">Frais</label>
                                        <input type="number" class="form-control form-control-lg" id="montant" name="montant" min="0" step="0.01" required>
                                    </div>
                                    <div class="col-12 d-grid d-sm-flex gap-2 mt-2">
                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Enregistrer les frais</button>
                                        <a href="/accueilOperateur" class="btn btn-outline-secondary btn-lg rounded-pill">Retour</a>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 col-xl-5">
                        <div class="metric-card h-100">
                            <div class="metric-label">Conseil de validation</div>
                            <div class="metric-value">3 champs</div>
                            <div class="metric-unit">Minimum, maximum et frais doivent rester numériques et cohérents.</div>
                            <hr class="my-4">
                            <p class="mb-2 fw-semibold">Bon usage</p>
                            <ul class="mb-0 text-muted-soft ps-3">
                                <li>Gardez le montant minimum inférieur au montant maximum.</li>
                                <li>Utilisez des montants simples avec deux décimales si nécessaire.</li>
                                <li>Évitez les libellés trop longs pour garder la grille lisible.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>