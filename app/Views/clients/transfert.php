<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('clients/partials/head', ['opTitle' => 'Faire un transfert']) ?>
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
            <?= view('clients/partials/sidebar', ['opActive' => 'transfert']) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('clients/partials/sidebar', ['opActive' => 'transfert']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <h1 class="op-page-title h3 mb-4">Faire un transfert</h1>

            <div class="op-card p-3 p-lg-4" style="max-width: 480px;">
                <?php if (session()->getFlashdata('erreur')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('erreur') ?></div>
                <?php endif; ?>

                <form action="/transfert/save" method="post" class="op-needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" min="1" required>
                        <div class="invalid-feedback">Merci d'indiquer un montant valide (superieur a 0).</div>
                    </div>

                    <div class="mb-3">
                        <label for="numero" class="form-label">Numero du destinataire</label>
                        <input type="tel" class="form-control" id="numero" name="numero" minlength="10"
                            maxlength="10" pattern="[0-9]{10}" inputmode="numeric" required
                            placeholder="Ex : 0320000000">
                        <div class="invalid-feedback">Merci d'indiquer un numero valide (10 chiffres).</div>
                    </div>

                    <div class="mb-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>

                    <button type="submit" class="btn btn-op-primary">
                        <i class="bi bi-arrow-left-right"></i> Transferer
                    </button>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
