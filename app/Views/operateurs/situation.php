<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('operateurs/partials/head', ['opTitle' => 'Mes gains']) ?>
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
            <?= view('operateurs/partials/sidebar', ['opActive' => 'situation']) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('operateurs/partials/sidebar', ['opActive' => 'situation']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <h1 class="op-page-title h3 mb-4">Mes gains</h1>

            <div class="op-card p-3 p-lg-4 mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col">
                        <div class="text-muted small">Gain total</div>
                        <div class="op-stat-value fs-3"><?= esc((string) $somme) ?></div>
                    </div>
                </div>
            </div>

            <div class="op-card p-3 p-lg-4">
                <h2 class="h5 mb-3">Detail des opérations</h2>

                <form action="/filtreGain" method="post">
                    <select name="categorie" id="">
                            <option value="all">Tous</option>
                        <?php foreach($types as $t){ ?>
                            <option value="<?= $t["idType_operation"] ?>"> <?= $t["nom"] ?> </option>
                        <?php } ?>
                    </select>

                    <input type="submit" value="Filtrer">
                </form>

                <?php if (!empty($details)): ?>
                    <div class="table-responsive">
                        <table class="table op-table align-middle">
                            <thead>
                                <tr>
                                    <th>Operation</th>
                                    <th>Client</th>
                                    <th>Date d'operation</th>
                                    <th>Montant</th>
                                    <th>Frais d'operation (Gain)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($details as $d): ?>
                                    <tr>
                                        <td><?= esc($d["type"]) ?></td>
                                        <td><?= esc($d["client"]) ?></td>
                                        <td><?= esc($d["date"]) ?></td>
                                        <td><?= esc((string) $d["montant"]) ?></td>
                                        <td><?= esc((string) $d["gain"]) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="op-empty mb-0">Aucune operation pour le moment.</p>
                <?php endif; ?>
            </div>
            <div class="op-card p-3 p-lg-4">
                <h2 class="h5 mb-3">Autres opérateurs</h2>

                <?php if (!empty($details)): ?>
                    <div class="table-responsive">
                        <table class="table op-table align-middle">
                            <thead>
                                <tr>
                                    <th>Operation</th>
                                    <th>Client</th>
                                    <th>Date d'operation</th>
                                    <th>Montant</th>
                                    <th>Frais d'operation (Gain)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($details as $d): ?>
                                    <tr>
                                        <td>
                                            <?= esc($d["type"]) ?>
                                        </td>
                                        <td>
                                            <?= esc($d["client"]) ?>
                                        </td>
                                        <td>
                                            <?= esc($d["date"]) ?>
                                        </td>
                                        <td>
                                            <?= esc((string) $d["montant"]) ?>
                                        </td>
                                        <td>
                                            <?= esc((string) $d["gain"]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="op-empty mb-0">Aucune operation pour le moment.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>