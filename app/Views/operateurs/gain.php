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
            <th>Opération</th>
            <th>Client</th>
            <th>Date d'opération</th>
            <th>Montant</th>
            <th>Frais d'opération (Gain)</th>
        </tr>

        <?php foreach($details as $d){ ?>
            <tr>
                <td><?= $d["operateur"] ?></td>
                <td><?= $d["type"] ?></td>
                <td><?= $d["client"] ?></td>
                <td><?= $d["date"] ?></td>
                <td><?= $d["montant"] ?></td>
                <td><?= $d["gain"] ?></td>
            </tr>
        <?php } ?>
    </table>

    <h3>Votre gain: <?= $somme ?></h3>
</body>
</html>