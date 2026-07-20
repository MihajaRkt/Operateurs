<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Retrait</title>
</head>

<body>

    <h1>Faire un transfert</h1>

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
        </p>

        <input type="submit" value="Transferer">

    </form>

    <br>

    <a href="/accueil">Retour</a>

</body>

</html>