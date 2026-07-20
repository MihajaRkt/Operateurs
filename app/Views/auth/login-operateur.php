<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Operateur</title>
</head>
<body>
    <h1>Connectez-vous</h1>
    <form action="/loginOperateur" method="post">
        <p> Entrez votre numero <input type="text" name="numero"> </p>
        <input type="submit" value="Se connecter">
    </form>
    <?php if(isset($error)){ ?>
        <p style="color: red;"> <?= esc($error) ?> </p>
    <?php }?>
</body>
</html>