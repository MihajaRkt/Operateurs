<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de login</title>
</head>

<body>
    <h1>Login</h1>

    <form action="/clientLogin" method="post">
        <p>Entrez votre numero <input type="tel" name="numero"
                minlength="10" value="0320000000">
            <input type="submit" value="Confirmer">
        </p>
    </form>

    <?php if (session()->getFlashdata('erreur')) : ?>

        <p style="color:red;">
            <?= session()->getFlashdata('erreur') ?>
        </p>

    <?php endif; ?>
</body>

</html>