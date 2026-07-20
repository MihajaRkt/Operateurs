<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gains - Operateurs</title>
</head>
<body>
    <h1> Gains </h1>
    <table border="1">
        <tr>
            <th>Opérateur</th>
            <th>Client</th>
            <th>Solde</th>
        </tr>

        <?php foreach($details as $d){ ?>
            <tr>
                <td><?= $d["operateur"] ?></td>
                <td><?= $d["client"] ?></td>
                <td><?= $d["solde"] ?></td>
                <td><a href="/profil/<?= $d["idClient"] ?>">Voir profil</a></td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>