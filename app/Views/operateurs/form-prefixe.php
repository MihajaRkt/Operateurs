<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prefixe - Operateur</title>
</head>

<body>
    <h1>Ajouter un prefixe</h1>
    <form action="/ajouterPrefixe" method="post">
        <p> Entrez un prefixe <input type="text" name="prefixe"></p>
        <input type="submit" value="Ajouter">
    </form>

    <h2>Préfixes de <?= $user['nom'] ?> actuellement</h2>
    <table border="1">
        <tr>
            <th>Prefixe</th>
        </tr>

        <?php if (!empty($operateurs)) { ?>
            <?php foreach ($operateurs as $o) { ?>
                <tr>
                    <td><?= $o['prefixe'] ?></td>
                </tr>
            <?php } ?>

        <?php } ?>
    </table>
</body>

</html>