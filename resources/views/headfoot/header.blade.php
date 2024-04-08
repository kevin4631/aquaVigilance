<header>
    <div class="logoTitre">
        <img class="logo" src="img/logo.png" alt="logo">
        <h1 class="titre">AquaVigilance</h1>
    </div>

    <div class="boutonHeader">
        @auth <!--Si l'utilisateur est connecté-->
        <div class="button-container">
            <a class="buttonH" href="{{route('temp_formulaire')}}">Page temperature</a>
            <a class="buttonH" href="{{route('deconnexion')}}">Déconnexion</a>
        </div>
        @else <!--Si il est pas connecté-->
        <div class="button-container">
            <a class="buttonH" href="{{ route('connexion') }}">Connexion</a>
        </div>
        @endauth
    </div>
</header>