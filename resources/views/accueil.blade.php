<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaVigilance</title>
    <link rel="stylesheet" href="css/accueil.css">
</head>

<body>

    @auth <!--Si l'utilisateur est connecté-->
    <div>
        <a href="{{route('deconnexion')}}" class="deco-btn">Déonnexion</a>
        <a href="{{route('temp_formulaire')}}" class="temperature-btn">Page Temperature</a>

    
    </div>
    @else <!--Si il est pas connecté-->
    <div>
        <a href="{{ route('connexion') }}" class="login-btn">Connexion</a>
    </div>
    @endauth

    @include('headfoot/header')

    @include('carte/map')

    @include('headfoot/footer')

</body>

</html>
