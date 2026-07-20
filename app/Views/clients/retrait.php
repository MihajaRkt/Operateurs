<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Retrait</title>
</head>

<body>

    <h1>Faire un retrait</h1>

    <?php if (session()->getFlashdata('erreur')) : ?>
        <p style="color: red;">
            <?= session()->getFlashdata('erreur') ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($erreur)) : ?>
        <p style="color: red;">
            <?= esc($erreur) ?>
        </p>
    <?php endif; ?>

    <form action="/retrait/save" method="post">

        <p>
            Montant :
            <input
                type="number"
                name="montant"
                min="1"
                required>
        </p>

        <p>
            Date :
            <input type="date" name="date" required>
        </p>

        <input type="submit" value="Retirer">

    </form>

    <br>

    <a href="/accueil">Retour</a>

</body>

</html>