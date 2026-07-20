<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('operateurs/partials/head', ['opTitle' => 'Commission']) ?>
</head>

<body class="op-body">

    <?php
    $user = $user ?? (session()->get('user') ?? []);
    $commission = $commission ?? null;
    $pourcentage = isset($pourcentage)
        ? (float) $pourcentage
        : (float) ($commission['pourcentage'] ?? 0);
    ?>

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
            <?= view('operateurs/partials/sidebar', ['user' => $user ?? null, 'opActive' => 'commission']) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('operateurs/partials/sidebar', ['user' => $user ?? null, 'opActive' => 'commission']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <h1 class="op-page-title h3 mb-4">Configuration de commission</h1>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('erreur')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('erreur') ?></div>
            <?php endif; ?>

            <?php if (!empty($commission)) : ?>
                <div class="op-card p-3 p-lg-4 mb-4" style="max-width: 480px;">
                    <form action="/voirCommission" method="post" class="row g-3 align-items-end">
                        <div class="col-12">
                            <label for="pourcentage" class="form-label">Commission (%)</label>
                            <input type="number"
                                   class="form-control"
                                   id="pourcentage"
                                   name="pourcentage"
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   value="<?= esc((string) $pourcentage) ?>"
                                   required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-op-primary">
                                <i class="bi bi-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="op-card p-3 p-lg-4 mb-4" style="max-width: 480px;">
                    <form action="/voirCommission" method="post" class="row g-3 align-items-end">
                        <div class="col-12">
                            <label for="pourcentage" class="form-label">Commission (%)</label>
                            <input type="number"
                                   class="form-control"
                                   id="pourcentage"
                                   name="pourcentage"
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   value="0"
                                   required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-op-primary">
                                <i class="bi bi-plus-lg"></i> Créer la commission
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <div class="op-card p-3 p-lg-4">
                <h2 class="h5 mb-3">Commission actuelle de <?= esc($user['nom'] ?? '') ?></h2>
                <p class="op-empty mb-0">Valeur enregistrée : <?= esc((string) $pourcentage) ?>%</p>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
