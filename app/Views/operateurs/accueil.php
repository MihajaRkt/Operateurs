<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Operateur</title>
</head>
<body>
    <h1>Operateur <?= $user["nom"] ?> </h1>
    <a href="/ajouterPrefixe"> Ajouter un prefixe</a>
    <a href="/ajouterFrais"> Ajouter des frais </a>
    <a href="/voirGain/<?= $user["nom"] ?>"> Voir votre gain </a>
    <table border="1">
        <tr>
            <th>Description</th>
            <th>Montant min</th>
            <th>Montant max</th>
            <th>Frais</th>
        </tr>

        <?php foreach($frais as $f){ ?>
            <tr>
                <td><?= $f["description"] ?></td>
                <td><?= $f["montantMin"] ?></td>
                <td><?= $f["montantMax"] ?></td>
                <td><?= $f["montant"] ?></td>
                <td><a href="/modifierFrais/<?= $f["idFrais"] ?>">Modifier</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>