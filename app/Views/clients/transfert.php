<!DOCTYPE html>
<html lang="fr">

<head>
    <?= view("clients/partials/head", ["opTitle" => "Faire un transfert"]) ?>
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
            <?= view("clients/partials/sidebar", ["opActive" => "transfert"]) ?>
        </div>
    </div>

    <div class="d-flex">
        <aside class="op-sidebar op-sidebar-desktop d-none d-lg-block">
            <?= view("clients/partials/sidebar", ["opActive" => "transfert"]) ?>
        </aside>

        <main class="op-main p-3 p-lg-4">
            <h1 class="op-page-title h3 mb-4">Faire un transfert</h1>

            <div class="op-card p-3 p-lg-4" style="max-width: 480px;">
                <?php if (session()->getFlashdata("erreur")): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata(
                                                        "erreur",
                                                    ) ?></div>
                <?php endif; ?>

                <?php
                $sessionUser = session()->get("user") ?? [];
                $senderPrefix = substr($sessionUser["telephone"] ?? "", 0, 3);
                ?>

                <form action="/transfert/save" method="post" class="op-needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant total (Ar)</label>
                        <input type="number" class="form-control" id="montant" name="montant" min="1" required>
                        <div class="invalid-feedback">Merci d'indiquer un montant valide (supérieur à 0).</div>
                    </div>

                    <div class="mb-3">
                        <label for="numeros" class="form-label">Numéro(s) destinataire(s)</label>
                        <textarea class="form-control" id="numeros" name="numeros" rows="3" required
                            placeholder="Ex : 0320000000&#10;Pour plusieurs : 0320000001, 0320000002"></textarea>
                        <small class="text-muted">
                            Séparez plusieurs numéros par une virgule ou un saut de ligne.
                            <span id="multiInfo" class="d-none fw-semibold text-warning">
                                &nbsp;— Envoi multiple : même opérateur, montant divisé équitablement.
                            </span>
                        </small>
                        <div class="invalid-feedback">Veuillez indiquer au moins un numéro valide.</div>
                    </div>

                    <div class="mb-3 d-none" id="fraisRetraitBlock">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="inclure_frais_retrait"
                                name="inclure_frais_retrait" value="1">
                            <label class="form-check-label" for="inclure_frais_retrait">
                                Couvrir les frais de retrait du / des destinataire(s)
                            </label>
                        </div>
                        <small class="text-muted">Disponible uniquement entre comptes du même opérateur.</small>
                    </div>

                    <div class="mb-4">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>

                    <button type="submit" class="btn btn-op-primary">
                        <i class="bi bi-arrow-left-right"></i> Transférer
                    </button>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/operateur.js"></script>
    <script>
        (function() {
            const networks = {
                '032': 'Orange',
                '037': 'Orange',
                '033': 'Airtel',
                '034': 'Yas',
                '038': 'Yas',
            };
            const senderNetwork = networks['<?= esc($senderPrefix) ?>'] ?? null;
            const textarea = document.getElementById('numeros');
            const block = document.getElementById('fraisRetraitBlock');
            const checkbox = document.getElementById('inclure_frais_retrait');
            const multiInfo = document.getElementById('multiInfo');

            function parseNums(raw) {
                return [...new Set(raw.split(/[\s,;]+/).map(s => s.trim()).filter(Boolean))];
            }

            function update() {
                const nums = parseNums(textarea.value);
                const isMulti = nums.length > 1;
                multiInfo.classList.toggle('d-none', !isMulti);

                const allSame = senderNetwork && nums.length > 0 &&
                    nums.every(n => networks[n.substring(0, 3)] === senderNetwork);

                block.classList.toggle('d-none', !allSame);
                if (!allSame) checkbox.checked = false;
            }

            textarea.addEventListener('input', update);
        })();
    </script>
</body>

</html>