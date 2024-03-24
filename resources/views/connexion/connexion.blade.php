<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="css/form.css">
</head>



 <body>
    @include('headfoot/header')

    <div class="login_div">
        <form class="login_form" method="post">@csrf
        <h1>Connexion</h1>
        <input type="email" name="email" placeholder="Adresse mail">
        <input type="password" name="password" placeholder="Mot de passe">
        <button type="submit" formaction="{{route('authentification')}}">Se connecter</button>
        <button class="button1" type="submit" formaction="{{ route('reinitialier_form') }}">Mot de passe oublié ?</button>
        <button type="submit" formaction="{{route('inscription_form')}}">Créer un compte</button>
        </form>
    </div>

    @include('headfoot/footer')

 </body> 

</html>





