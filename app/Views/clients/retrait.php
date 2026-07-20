<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Retrait</title>
</head>

<body>

    <h1>Faire un retrait</h1>

    <form action="/retrait/save" method="post">

        <p>
            Montant :
            <input
                type="number"
                name="montant"
                min="1"
                required>
        </p>

        <input type="submit" value="Retirer">

    </form>

    <br>

    <a href="/accueil">Retour</a>

</body>

</html>