<?php
$user = $user ?? (session()->get('user') ?? []);
$userName = $user['nom'] ?? 'Opérateur';
$frais = $frais ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil opérateur</title>
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
                <p class="operator-sidebar__brand-subtitle">Espace de pilotage pour les préfixes, frais et opérations.</p>
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
                <a href="/voirGain/<?= $user['nom'] ?>" data-sidebar-link>
                    <span class="operator-sidebar__nav-icon">€</span>
                    <span>Voir les gains</span>
                </a>
                <a href="/compteClients/<?= $user['nom'] ?>" data-sidebar-link>
                    <span class="operator-sidebar__nav-icon">👥</span>
                    <span>Voir les clients</span>
                </a>
            </nav>

            <div class="operator-sidebar__footer">
                <p class="mb-1 fw-semibold text-white">Connecté comme</p>
                <p class="mb-0"><?= $user['nom'] ?></p>
            </div>
        </aside>

        <main class="operator-main">
            <header class="operator-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="sidebar-toggle" data-sidebar-toggle aria-label="Ouvrir le menu">☰</button>
                    <div>
                        <h1 class="operator-topbar__title">Bonjour <?= $user['nom'] ?></h1>
                        <p class="operator-topbar__subtitle">Gérez vos frais et suivez l’activité en quelques clics.</p>
                    </div>
                </div>
                <div class="operator-topbar__actions">
                    <span class="badge rounded-pill text-bg-light border px-3 py-2">Frais configurés: <?= count($frais) ?></span>
                    <a class="btn btn-primary rounded-pill" href="/ajouterFrais">Nouveau frais</a>
                </div>
            </header>

            <section class="operator-content">
                <div class="hero-banner">
                    <p class="text-uppercase fw-bold mb-2" style="letter-spacing:.08em; color: rgba(255,255,255,.7);">Tableau de bord</p>
                    <h1 class="mb-3">Une vue claire pour piloter les règles de frais et les comptes clients.</h1>
                    <p class="mb-0 text-white-50">Accédez rapidement aux préfixes autorisés, ajustez vos frais et consultez les opérations enregistrées.</p>
                </div>

                <div class="metric-grid">
                    <div class="metric-card">
                        <div class="metric-label">Frais enregistrés</div>
                        <div class="metric-value"><?= count($frais) ?></div>
                        <div class="metric-unit">règles actives</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Opérateur</div>
                        <div class="metric-value"><?= $user['nom'] ?></div>
                        <div class="metric-unit">profil courant</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Actions rapides</div>
                        <div class="metric-value">4</div>
                        <div class="metric-unit">liens prioritaires</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Contrôle</div>
                        <div class="metric-value">100%</div>
                        <div class="metric-unit">interface serveur</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 p-4 pb-0">
                            <div>
                                <h2 class="card-title mb-1">Liste des frais</h2>
                                <p class="card-subtitle">Chaque ligne correspond à une plage de montant et à son frais associé.</p>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="/ajouterPrefixe" class="btn btn-outline-secondary rounded-pill">Préfixes</a>
                                <a href="/compteClients/<?= $user['nom'] ?>" class="btn btn-outline-secondary rounded-pill">Clients</a>
                            </div>
                        </div>

                        <div class="data-table-wrapper mt-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Montant min</th>
                                            <th>Montant max</th>
                                            <th>Frais</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($frais)): ?>
                                            <?php foreach ($frais as $f): ?>
                                                <tr>
                                                    <td><?= esc($f['description']) ?></td>
                                                    <td><?= esc($f['montantMin']) ?></td>
                                                    <td><?= esc($f['montantMax']) ?></td>
                                                    <td><span class="badge rounded-pill text-bg-success-subtle text-success-emphasis"><?= esc($f['montant']) ?></span></td>
                                                    <td class="text-end">
                                                        <a class="btn btn-sm btn-outline-primary rounded-pill" href="/modifierFrais/<?= esc($f['idFrais']) ?>">Modifier</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5">
                                                    <div class="empty-state">Aucun frais n'est encore enregistré.</div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>