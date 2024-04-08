<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png" />

    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css"/>
    <link rel="stylesheet" href="css/header.css" />
</head>

   
 <body>
    @include('headfoot/header')

    <div class="creation_div">
        <form class="creation_form"  action="{{route('reset')}}" method="post">@csrf
        <h1>Changement de mot de passe</h1>
        <input type="email" name="email" placeholder="adresse mail" required>
        <input type="password" name="password" placeholder=" nouveau mot de passe" required>
        <button type="submit">Changer le mot de passe</button>
    </form>
    </div>
 </body>   




</html>
