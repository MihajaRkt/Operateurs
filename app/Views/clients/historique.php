<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view("clients/partials/head", ["opTitle" => "Mes actions"]) ?>
</head>

<body class="op-body">

    <nav class="navbar op-topbar d-lg-none px-3 py-2">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#clSidebarOffcanvas" aria-controls="clSidebarOffcanvas">
            <i class="bi bi-list fs-4"></i>
        </button>
        <span class="op-brand ms-2">Espace Client</span>
    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="clSidebarOffcanvas">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body p-0">
            <?= view("clients/partials/sidebar", [
                "user" => $user ?? null,
                "opActive" => "historique",
            ]) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view("clients/partials/sidebar", [
                "user" => $user ?? null,
                "opActive" => "historique",
            ]) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <?php
            $user = $user ?? [];
            $operations = $operations ?? [];
            ?>

            <h1 class="op-page-title h3 mb-4">
                Historique des operations — <?= esc($user["nom"] ?? "") ?>
            </h1>

            <div class="op-card p-3 p-lg-4">
                <?php if (empty($operations)): ?>
                    <p class="op-empty mb-0">Aucune operation enregistree.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table op-table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Montant (Ar)</th>
                                    <th>Frais (Ar)</th>
                                    <th>Correspondant</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($operations as $op):

                                    $destNom = $op["destinataire_nom"] ?? null;
                                    $destTel =
                                        $op["destinataire_telephone"] ?? null;
                                    ?>
                                    <tr>
                                        <td><?= esc($op["idOperation"]) ?></td>
                                        <td><?= esc(
                                            $op["type_nom"] ?? "-",
                                        ) ?></td>
                                        <td><?= esc(
                                            number_format(
                                                (float) $op["montant"],
                                                2,
                                                ",",
                                                " ",
                                            ),
                                        ) ?></td>
                                        <td>
                                            <?= $op["frais_montant"] !== null
                                                ? esc(
                                                    number_format(
                                                        (float) $op[
                                                            "frais_montant"
                                                        ],
                                                        2,
                                                        ",",
                                                        " ",
                                                    ),
                                                )
                                                : "-" ?>
                                        </td>
                                        <td>
                                            <?php if ($destNom): ?>
                                                <?= esc($destNom) ?>
                                                <br><small class="text-muted"><?= esc(
                                                    $destTel,
                                                ) ?></small>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc(
                                            $op["date_operation"],
                                        ) ?></td>
                                    </tr>
                                <?php
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
