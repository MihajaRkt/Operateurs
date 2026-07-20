<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Connecteez-vous</h1>
    <form action="/login" method="post">
        <p> Entrez votre email <input type="email" name="email"> </p>
        <p> Entrez votre mot de passe <input type="password" name="password"> </p>
        <input type="submit" value="Se connecter">
    </form>
    <?php if(isset($error)){ ?>
        <p style="color: red;"> <?= esc($error) ?> </p>
    <?php }?>
</body>
</html>