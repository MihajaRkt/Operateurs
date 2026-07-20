<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view('operateurs/partials/head', ['opTitle' => 'Mes prefixes']) ?>
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
            <?= view('operateurs/partials/sidebar', ['user' => $user ?? null, 'opActive' => 'prefixe']) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view('operateurs/partials/sidebar', ['user' => $user ?? null, 'opActive' => 'prefixe']) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <h1 class="op-page-title h3 mb-4">Ajouter un prefixe</h1>

            <div class="op-card p-3 p-lg-4 mb-4" style="max-width: 480px;">
                <form action="/ajouterPrefixe" method="post" class="op-needs-validation row g-2" novalidate>
                    <div class="col-8">
                        <label for="prefixe" class="form-label visually-hidden">Prefixe</label>
                        <input type="text" class="form-control" id="prefixe" name="prefixe" required
                            pattern="[0-9]{3}" maxlength="3" inputmode="numeric" placeholder="Ex : 032">
                        <div class="invalid-feedback">Le prefixe doit contenir exactement 3 chiffres.</div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-op-primary w-100">
                            <i class="bi bi-plus-lg"></i> Ajouter
                        </button>
                    </div>
                </form>
            </div>

            <div class="op-card p-3 p-lg-4">
                <h2 class="h5 mb-3">Prefixes de <?= esc($user['nom'] ?? '') ?> actuellement</h2>

                <?php if (!empty($operateurs)): ?>
                    <div class="table-responsive">
                        <table class="table op-table align-middle" style="max-width: 320px;">
                            <thead>
                                <tr>
                                    <th>Prefixe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($operateurs as $o): ?>
                                    <tr>
                                        <td><?= esc($o['prefixe']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="op-empty mb-0">Aucun prefixe enregistre pour le moment.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
</body>

</html>
