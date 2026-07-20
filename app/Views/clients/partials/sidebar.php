<?php
// Sidebar client - include partagé par toutes les vues du back-office client.
// On retombe sur la session si $user n'a pas ete transmis par le controleur,
// sans rien changer aux controleurs.
$user = $user ?? (session()->get('user') ?? []);
$clNom = $user['nom'] ?? '';
$opActive = $opActive ?? '';

$clInitiale = $clNom !== '' ? mb_strtoupper(mb_substr($clNom, 0, 1)) : 'C';

$clLinks = [
    'accueil' => [
        'href'  => '/accueil',
        'label' => 'Tableau de bord',
        'icon'  => 'bi-speedometer2',
    ],
    'transfert' => [
        'href'  => '/transfert-form',
        'label' => 'Faire un transfert',
        'icon'  => 'bi-arrow-left-right',
    ],
    'depot' => [
        'href'  => '/depot-form',
        'label' => 'Faire un depot',
        'icon'  => 'bi-piggy-bank',
    ],
    'retrait' => [
        'href'  => '/retrait-form',
        'label' => 'Faire un retrait',
        'icon'  => 'bi-wallet2',
    ],
    'historique' => [
        'href'  => '/historique',
        'label' => 'Mes actions',
        'icon'  => 'bi-clock-history',
    ],
];
?>
<div class="d-flex flex-column p-3 h-100">
    <a href="/accueil" class="op-brand d-flex align-items-center gap-2 text-decoration-none mb-3">
        <i class="bi bi-wallet2 fs-4"></i>
        <span>Espace Client</span>
    </a>

    <div class="op-user d-flex align-items-center gap-2 mb-3">
        <div class="op-avatar"><?= esc($clInitiale) ?></div>
        <div class="text-truncate">
            <div class="fw-semibold text-truncate"><?= esc($clNom !== '' ? $clNom : 'Client') ?></div>
            <div class="small text-muted">Compte client</div>
        </div>
    </div>

    <nav class="op-nav nav nav-pills flex-column gap-1 mb-auto">
        <?php foreach ($clLinks as $key => $link): ?>
            <a href="<?= $link['href'] ?>"
               class="nav-link <?= $opActive === $key ? 'active' : '' ?>">
                <i class="bi <?= $link['icon'] ?>"></i>
                <span><?= esc($link['label']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <hr>

    <a href="/logout" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right"></i>
        <span>Deconnexion</span>
    </a>
</div>
