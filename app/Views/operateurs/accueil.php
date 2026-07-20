<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('operateurs/partials/head', ['opTitle' => 'Tableau de bord']) ?>
</head>

<body class="op-body">

    <!-- Topbar mobile -->
    <nav class="navbar op-topbar d-lg-none px-3 py-2">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#opSidebarOffcanvas" aria-controls="opSidebarOffcanvas">
            <i class="bi bi-list fs-4"></i>
        </button>
        <span class="op-brand ms-2">Espace Operateur</span>
    </nav>

    <!-- Sidebar mobile (offcanvas) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="opSidebarOffcanvas">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body p-0">
            <?= view('operateurs/partials/sidebar', ['user' => $user ?? null, 'opActive' => 'accueil']) ?>
        </div>
    </div>

    <div class="d-flex">
        <!-- Sidebar desktop -->
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('operateurs/partials/sidebar', ['user' => $user ?? null, 'opActive' => 'accueil']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <h1 class="op-page-title h3 mb-0">Bonjour, <?= esc($user["nom"] ?? '') ?></h1>
            </div>

            <!-- Actions rapides -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <a href="/ajouterPrefixe" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-upc-scan"></i></span>
                        <span class="fw-semibold">Ajouter un prefixe</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/ajouterFrais" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-cash-coin"></i></span>
                        <span class="fw-semibold">Ajouter des frais</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/voirGain/<?= esc($user["nom"] ?? '') ?>" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-graph-up-arrow"></i></span>
                        <span class="fw-semibold">Voir votre gain</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/compteClients/<?= esc($user["nom"] ?? '') ?>" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-people"></i></span>
                        <span class="fw-semibold">Voir les clients</span>
                    </a>
                </div>
            </div>

            <!-- Tableau des frais -->
            <div class="op-card p-3 p-lg-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0">Frais configures</h2>
                    <a href="/ajouterFrais" class="btn btn-op-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Ajouter un frais
                    </a>
                </div>

                <?php if (!empty($frais)): ?>
                    <div class="table-responsive">
                        <table class="table op-table align-middle">
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
                                <?php foreach ($frais as $f): ?>
                                    <tr>
                                        <td><?= esc($f["description"]) ?></td>
                                        <td><?= esc((string) $f["montantMin"]) ?> Ar</td>
                                        <td><?= esc((string) $f["montantMax"]) ?> Ar</td>
                                        <td><?= esc((string) $f["montant"]) ?> Ar</td>
                                        <td class="text-end">
                                            <a href="/modifierFrais/<?= esc((string) $f["idFrais"]) ?>"
                                                class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-pencil-square"></i> Modifier
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="op-empty mb-0">Aucun frais configure pour le moment.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
