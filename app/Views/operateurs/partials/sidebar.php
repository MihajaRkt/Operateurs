<?php
// Sidebar operateur - include partagé par toutes les vues du back-office operateur.
// On retombe sur la session si $user n'a pas ete transmis par le controleur
// (meme pattern que app/Views/clients/accueil.php), sans rien changer aux controleurs.
$user = $user ?? (session()->get('user') ?? []);
$opNom = $user['nom'] ?? '';
$opActive = $opActive ?? '';

$opInitiale = $opNom !== '' ? mb_strtoupper(mb_substr($opNom, 0, 1)) : 'O';

$opLinks = [
    'accueil' => [
        'href'  => '/accueilOperateur',
        'label' => 'Tableau de bord',
        'icon'  => 'bi-speedometer2',
    ],
    'prefixe' => [
        'href'  => '/ajouterPrefixe',
        'label' => 'Mes prefixes',
        'icon'  => 'bi-upc-scan',
    ],
    'frais' => [
        'href'  => '/ajouterFrais',
        'label' => 'Frais operateur',
        'icon'  => 'bi-cash-coin',
    ],
    'commission' => [
        'href'  => '/voirCommission',
        'label' => 'Configuration de commission',
        'icon'  => 'bi-cash-coin',
    ],
    'gain' => [
        'href'  => '/voirGain/' . rawurlencode((string) $opNom),
        'label' => 'Mes gains',
        'icon'  => 'bi-graph-up-arrow',
    ],
    'situation' => [
        'href'  => '/gainSepare',
        'label' => 'Situation gain',
        'icon'  => 'bi-cash',
    ],

    'clients' => [
        'href'  => '/compteClients/' . rawurlencode((string) $opNom),
        'label' => 'Mes clients',
        'icon'  => 'bi-people',
    ],
];
?>
<div class="d-flex flex-column p-3 h-100">
    <a href="/accueilOperateur" class="op-brand d-flex align-items-center gap-2 text-decoration-none mb-3">
        <i class="bi bi-broadcast fs-4"></i>
        <span>Espace Operateur</span>
    </a>

    <div class="op-user d-flex align-items-center gap-2 mb-3">
        <div class="op-avatar"><?= esc($opInitiale) ?></div>
        <div class="text-truncate">
            <div class="fw-semibold text-truncate"><?= esc($opNom !== '' ? $opNom : 'Operateur') ?></div>
            <div class="small text-muted">Compte operateur</div>
        </div>
    </div>

    <nav class="op-nav nav nav-pills flex-column gap-1 mb-auto">
        <?php foreach ($opLinks as $key => $link): ?>
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
