<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css"/>
    <link rel="stylesheet" href="css/header.css" />
</head>

    
 <body>
    @include('headfoot/header')

    <div class="creation_div">
        <form class="creation_form"  action="{{route('inscription')}}" method="post">@csrf
        <h1>Création de compte</h1>
        <input type="name" name="name" placeholder="nom utilisateur ">
        <input type="email" name="email" placeholder="adresse mail">
        <input type="password" name="password" placeholder="mot de passe">
        <button type="submit">Créer un compte</button>
    </form>
    </div>
 </body>   

 @include('headfoot/footer')



</html>
