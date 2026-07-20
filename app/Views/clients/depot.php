<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dépôt</title>
</head>

<body>

    <h1>Faire un dépôt</h1>

    <form action="/depot/save" method="post">

        <p>
            Montant :
            <input
                type="number"
                name="montant"
                min="1"
                required>
        </p>

        <input type="submit" value="Déposer">

    </form>

    <br>

    <a href="/accueil">Retour</a>

</body>

</html>