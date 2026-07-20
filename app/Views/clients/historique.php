<?php
$user = $user ?? [];
$operations = $operations ?? [];
?>

<h1>Historique des opérations — <?= esc($user['nom'] ?? '') ?></h1>

<a href="/accueil">← Retour à l'accueil</a>

<?php if (empty($operations)): ?>
    <p>Aucune opération enregistrée.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Montant (Ar)</th>
                <th>Frais (Ar)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($operations as $op): ?>
                <tr>
                    <td><?= esc($op['idOperation']) ?></td>
                    <td><?= esc($op['type_nom'] ?? '-') ?></td>
                    <td><?= esc(number_format((float)$op['montant'], 2, ',', ' ')) ?></td>
                    <td><?= $op['frais_montant'] !== null ? esc(number_format((float)$op['frais_montant'], 2, ',', ' ')) : '-' ?></td>
                    <td><?= esc($op['date_operation']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
