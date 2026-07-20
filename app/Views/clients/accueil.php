
<?php if (!empty($success)) : ?>
    <p style="color: green;">
        <?= esc($success) ?>
    </p>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
	<p style="color: green;">
		<?= session()->getFlashdata('success') ?>
	</p>
<?php endif; ?>

<?php if (session()->getFlashdata('erreur')) : ?>
	<p style="color: red;">
		<?= session()->getFlashdata('erreur') ?>
	</p>
<?php endif; ?>

<?php
$user = $user ?? session()->get('user') ?? [];
$solde = $solde ?? 0;
?>

<h1>Bonjour <?= esc($user['nom'] ?? '') ?></h1>
<h1>Votre solde actuelle: <?= esc((string) $solde) ?></h1>

<a href="/transfert-form">Faire un transfert</a>
<a href="/depot-form">Faire un depot</a>
<a href="/retrait-form">Faire un retrait</a>

<a href="">Mes actions</a>

