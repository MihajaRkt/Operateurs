<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout frais - Operateur</title>
</head>

<body>
    <h1>Ajouter un frais</h1>
    <?php if (!empty($frais)) { ?>
        <form action="/modifierFrais/<?= $frais["idFrais"] ?>" method="post">
            <p> Description <input type="text" name="desc" value="<?= $frais["description"] ?>"> </p>
            <p> Montant Min: <input type="number" name="min" min="0" value="<?= $frais["montantMin"] ?>"></p>
            <p> Montant Max: <input type="number" name="max" max="10000000" value="<?= $frais["montantMax"] ?>"></p>
            <p> Montant Frais: <input type="number" name="montant" value="<?= $frais["montant"] ?>"> </p>
            <input type="submit" value="Enregistrer les frais">
        </form>

    <?php } else { ?>
        <form action="/ajouterFrais" method="post">
            <p>Description <input type="text" name="desc"> </p>
            <p> Montant Min: <input type="number" name="min" min="0"></p>
            <p> Montant Max: <input type="number" name="max" max="10000000"></p>
            <p> Montant Frais: <input type="number" name="montant"> </p>
            <input type="submit" value="Enregistrer les frais">
        </form>

    <?php } ?>
</body>
</html>