<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gains - Operateurs</title>
</head>
<body>
    <h1> Gains </h1>
    <table border="1">
        <tr>
            <th>Opérateur</th>
            <th>Opération</th>
            <th>Client</th>
            <th>Date d'opération</th>
            <th>Montant</th>
            <th>Frais d'opération (Gain)</th>
        </tr>

        <?php foreach($details as $d){ ?>
            <tr>
                <td><?= $d["operateur"] ?></td>
                <td><?= $d["type"] ?></td>
                <td><?= $d["client"] ?></td>
                <td><?= $d["date"] ?></td>
                <td><?= $d["montant"] ?></td>
                <td><?= $d["gain"] ?></td>
            </tr>
        <?php } ?>
    </table>

    <h3>Votre gain: <?= $somme ?></h3>
</body>
<?php
$user = $user ?? (session()->get('user') ?? []);
$userName = $user['nom'] ?? 'Opérateur';
$details = $details ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gains opérateur</title>
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
                <p class="operator-sidebar__brand-subtitle">Visualisez vos opérations et le gain généré par chaque mouvement.</p>
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
                        <h1 class="operator-topbar__title">Gains de l'opérateur</h1>
                        <p class="operator-topbar__subtitle">Suivi des opérations et des frais générés par chaque client.</p>
                    </div>
                </div>
                <div class="operator-topbar__actions">
                    <a class="btn btn-outline-secondary rounded-pill" href="/accueilOperateur">Retour au dashboard</a>
                </div>
            </header>

            <section class="operator-content">
                <div class="hero-banner">
                    <p class="text-uppercase fw-bold mb-2" style="letter-spacing:.08em; color: rgba(255,255,255,.7);">Performance</p>
                    <h1 class="mb-3">Le gain cumulé reste visible à tout moment sur cette vue.</h1>
                    <p class="mb-0 text-white-50">Chaque ligne présente l'opération, le client concerné, le montant et la part de frais correspondante.</p>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 p-4 pb-0">
                            <div>
                                <h2 class="card-title mb-1">Détail des opérations</h2>
                                <p class="card-subtitle">Historique des gains générés par votre opérateur.</p>
                            </div>
                            <span class="badge rounded-pill text-bg-light border px-3 py-2"><?= count($details) ?> opération(s)</span>
                        </div>

                        <div class="data-table-wrapper mt-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Opérateur</th>
                                            <th>Client</th>
                                            <th>Solde</th>
                                            <th class="text-end">Profil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($details)): ?>
                                            <?php foreach ($details as $d): ?>
                                                <tr>
                                                    <td><?= esc($d['operateur']) ?></td>
                                                    <td><?= esc($d['client']) ?></td>
                                                    <td><span class="badge rounded-pill text-bg-success-subtle text-success-emphasis"><?= esc($d['solde']) ?></span></td>
                                                    <td class="text-end"><a class="btn btn-sm btn-outline-primary rounded-pill" href="/profil/<?= esc($d['idClient']) ?>">Voir profil</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4"><div class="empty-state">Aucune opération n'a encore généré de gain.</div></td>
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