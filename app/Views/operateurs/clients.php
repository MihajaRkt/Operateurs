<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('operateurs/partials/head', ['opTitle' => 'Mes clients']) ?>
</head>

<body class="op-body">

    <nav class="navbar op-topbar d-lg-none px-3 py-2">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#opSidebarOffcanvas" aria-controls="opSidebarOffcanvas">
            <i class="bi bi-list fs-4"></i>
        </button>
        <span class="op-brand ms-2">Espace Operateur</span>
    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="opSidebarOffcanvas">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body p-0">
            <?= view('operateurs/partials/sidebar', ['opActive' => 'clients']) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('operateurs/partials/sidebar', ['opActive' => 'clients']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <h1 class="op-page-title h3 mb-4">Mes clients</h1>

            <div class="op-card p-3 p-lg-4">
                <?php if (!empty($details)): ?>
                    <div class="table-responsive">
                        <table class="table op-table align-middle">
                            <thead>
                                <tr>
                                    <th>Operateur</th>
                                    <th>Client</th>
                                    <th>Solde</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($details as $d): ?>
                                    <tr>
                                        <td><?= esc($d["operateur"]) ?></td>
                                        <td><?= esc($d["client"]) ?></td>
                                        <td><?= esc((string) $d["solde"]) ?></td>
                                        <td class="text-end">
                                            <a href="/profil/<?= esc((string) $d["idClient"]) ?>"
                                                class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-person-lines-fill"></i> Voir profil
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="op-empty mb-0">Aucun client pour le moment.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
