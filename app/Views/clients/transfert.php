<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Transfert</title>
</head>

<body>

    <h1>Faire un transfert</h1>

    <?php if (session()->getFlashdata('erreur')) : ?>
        <p style="color: red;">
            <?= session()->getFlashdata('erreur') ?>
        </p>
    <?php endif; ?>

    <form action="/transfert/save" method="post">

        <p>
            Montant :
            <input
                type="number"
                name="montant"
                min="1"
                required>

            Numero :
            <input type="tel" name="numero"
                minlength="10">

            Date
            <input type="date" name="date">
        </p>

        <input type="submit" value="Transferer">

    </form>

    <br>

    <a href="/accueil">Retour</a>

</body>

</html>