<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('operateurs/partials/head', ['opTitle' => 'Frais operateur']) ?>
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
            <?= view('operateurs/partials/sidebar', ['opActive' => 'frais']) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('operateurs/partials/sidebar', ['opActive' => 'frais']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <h1 class="op-page-title h3 mb-4">
                <?= !empty($frais) ? 'Modifier le frais' : 'Ajouter un frais' ?>
            </h1>

            <div class="op-card p-3 p-lg-4" style="max-width: 640px;">
                <?php if (!empty($frais)): ?>
                    <form action="/modifierFrais/<?= esc((string) $frais["idFrais"]) ?>" method="post"
                        class="op-needs-validation" novalidate>

                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" class="form-control" id="desc" name="desc"
                                value="<?= esc($frais["description"]) ?>" required minlength="3" maxlength="255">
                            <div class="invalid-feedback">Merci d'indiquer une description (3 caracteres minimum).</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="min" class="form-label">Montant min</label>
                                <input type="number" class="form-control" id="min" name="min" min="0" step="1"
                                    value="<?= esc((string) $frais["montantMin"]) ?>" required
                                    data-op-role="montant-min">
                                <div class="invalid-feedback">Le montant min doit etre superieur ou egal a 0.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max" class="form-label">Montant max</label>
                                <input type="number" class="form-control" id="max" name="max" min="0" max="10000000"
                                    step="1" value="<?= esc((string) $frais["montantMax"]) ?>" required
                                    data-op-role="montant-max">
                                <div class="invalid-feedback">Le montant max doit etre compris entre 0 et 10 000 000.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="montant" class="form-label">Montant du frais</label>
                            <input type="number" class="form-control" id="montant" name="montant" min="0" step="1"
                                value="<?= esc((string) $frais["montant"]) ?>" required>
                            <div class="invalid-feedback">Merci d'indiquer un montant de frais valide (0 ou plus).</div>
                        </div>

                        <button type="submit" class="btn btn-op-primary">
                            <i class="bi bi-check-lg"></i> Enregistrer les frais
                        </button>
                    </form>

                <?php else: ?>
                    <form action="/ajouterFrais" method="post" class="op-needs-validation" novalidate>

                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <input type="text" class="form-control" id="desc" name="desc" required minlength="3"
                                maxlength="255" placeholder="Ex : Retrait guichet">
                            <div class="invalid-feedback">Merci d'indiquer une description (3 caracteres minimum).</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="min" class="form-label">Montant min</label>
                                <input type="number" class="form-control" id="min" name="min" min="0" step="1"
                                    required data-op-role="montant-min">
                                <div class="invalid-feedback">Le montant min doit etre superieur ou egal a 0.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="max" class="form-label">Montant max</label>
                                <input type="number" class="form-control" id="max" name="max" min="0" max="10000000"
                                    step="1" required data-op-role="montant-max">
                                <div class="invalid-feedback">Le montant max doit etre compris entre 0 et 10 000 000.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="montant" class="form-label">Montant du frais</label>
                            <input type="number" class="form-control" id="montant" name="montant" min="0" step="1"
                                required>
                            <div class="invalid-feedback">Merci d'indiquer un montant de frais valide (0 ou plus).</div>
                        </div>

                        <button type="submit" class="btn btn-op-primary">
                            <i class="bi bi-check-lg"></i> Enregistrer les frais
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
