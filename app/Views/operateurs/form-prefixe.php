<?php
$user = $user ?? (session()->get('user') ?? []);
$userName = $user['nom'] ?? 'Opérateur';
$operateurs = $operateurs ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préfixes opérateur</title>
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
                <p class="operator-sidebar__brand-subtitle">Centralisez les préfixes autorisés pour votre opérateur.</p>
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
                        <h1 class="operator-topbar__title">Préfixes de l'opérateur</h1>
                        <p class="operator-topbar__subtitle">Ajoutez un nouveau préfixe et gardez la liste à jour.</p>
                    </div>
                </div>
                <div class="operator-topbar__actions">
                    <a class="btn btn-outline-secondary rounded-pill" href="/accueilOperateur">Retour au dashboard</a>
                </div>
            </header>

            <section class="operator-content">
                <div class="row g-4">
                    <div class="col-12 col-xl-5">
                        <div class="form-shell h-100">
                            <p class="text-uppercase text-secondary fw-semibold small mb-1">Nouveau préfixe</p>
                            <h2 class="section-title mb-2">Enregistrer un préfixe</h2>
                            <p class="muted mb-4">Le champ est restreint à une suite numérique pour éviter les valeurs erronées.</p>

                            <form action="/ajouterPrefixe" method="post" class="row g-3">
                                <div class="col-12">
                                    <label for="prefixe" class="form-label">Préfixe</label>
                                    <input type="tel" class="form-control form-control-lg" id="prefixe" name="prefixe" inputmode="numeric" minlength="10" maxlength="12" pattern="[0-9]{10,12}" placeholder="Ex: 0320000000" required>
                                    <div class="form-text">10 à 12 chiffres selon la plage que vous utilisez.</div>
                                </div>
                                <div class="col-12 d-grid d-sm-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">Ajouter</button>
                                    <a href="/accueilOperateur" class="btn btn-outline-secondary btn-lg rounded-pill">Annuler</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-xl-7">
                        <div class="card h-100">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 p-4 pb-0">
                                    <div>
                                        <h2 class="card-title mb-1">Préfixes enregistrés</h2>
                                        <p class="card-subtitle">La liste ci-dessous reflète les préfixes liés à <?= esc($userName) ?>.</p>
                                    </div>
                                    <span class="badge rounded-pill text-bg-success-subtle text-success-emphasis px-3 py-2"><?= count($operateurs) ?> préfixe(s)</span>
                                </div>

                                <div class="data-table-wrapper mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Préfixe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($operateurs)): ?>
                                                    <?php foreach ($operateurs as $o): ?>
                                                        <tr>
                                                            <td><span class="badge rounded-pill text-bg-light border px-3 py-2"><?= esc($o['prefixe']) ?></span></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td><div class="empty-state">Aucun préfixe n'est enregistré pour le moment.</div></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>