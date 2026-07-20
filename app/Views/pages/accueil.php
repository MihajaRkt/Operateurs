<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Liste des produits</h1>

    <form action="/filtre" method="post">
        <select name="categorie" id="">
                <option value="all">Tous</option>
            <?php foreach($categories as $c){ ?>
                <option value="<?= $c["idCategorie"] ?>"> <?= $c["libelle"] ?> </option>
            <?php } ?>
        </select>

        <input type="submit" value="Filtrer">
    </form>

    <table border="1">
        <tr>
            <th>ID Produit</th>
            <th>Libelle</th>
            <th>Categorie</th>
            <th>Achat</th>
        </tr>

        <?php if (!empty($produits)) { ?>
            <?php foreach ($produits as $p) { ?>
                    <tr>
                        <td><?= $p["idProduit"] ?></td>
                        <td><?= $p["libelle"] ?></td>
                        <td><?= $p["libCategorie"] ?></td>
                        <td><a href="/acheter/<?= $p["idProduit"] ?>">Achat</a></td>
                    </tr>
            <?php } ?>

        <?php } ?>
    </table>
</body>
</html>