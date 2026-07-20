<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('clients/partials/head', ['opTitle' => 'Tableau de bord']) ?>
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
            <?= view('clients/partials/sidebar', ['opActive' => 'accueil']) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('clients/partials/sidebar', ['opActive' => 'accueil']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <?php
            $user = $user ?? (session()->get("user") ?? []);
            $solde = $solde ?? 0;
            ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= esc($success) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata("success")): ?>
                <div class="alert alert-success"><?= session()->getFlashdata("success") ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata("erreur")): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata("erreur") ?></div>
            <?php endif; ?>

            <h1 class="op-page-title h3 mb-4">Bonjour, <?= esc($user["nom"] ?? "") ?></h1>

            <div class="op-card p-3 p-lg-4 mb-4" style="max-width: 420px;">
                <div class="text-muted small">Votre solde actuel</div>
                <div class="op-stat-value fs-2"><?= esc((string) $solde) ?> Ar</div>
            </div>

            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <a href="/transfert-form" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-arrow-left-right"></i></span>
                        <span class="fw-semibold">Faire un transfert</span>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="/depot-form" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-piggy-bank"></i></span>
                        <span class="fw-semibold">Faire un depot</span>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="/retrait-form" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-wallet2"></i></span>
                        <span class="fw-semibold">Faire un retrait</span>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="/historique" class="op-quick-action">
                        <span class="op-quick-icon"><i class="bi bi-clock-history"></i></span>
                        <span class="fw-semibold">Mes actions</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
