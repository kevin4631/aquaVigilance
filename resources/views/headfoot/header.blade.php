<header>
    <div class="logoTitre">
        <img class="logo" src="img/logo.png" alt="logo">
        <h1 class="titre">AquaVigilance</h1>
    </div>

    <div class="boutonHeader">
        @auth <!--Si l'utilisateur est connecté-->
        <div class="button-container">
            <a class="buttonH" href="{{route('temp_formulaire')}}" class="temperature-btn">Page temperature</a>
            <a class="buttonH" href="{{route('deconnexion')}}" class="deco-btn">Déconnexion</a>
        </div>
        @else <!--Si il est pas connecté-->
        <div class="button-container">
            <a class="buttonH" href="{{ route('connexion') }}" class="login-btn">Connexion</a>
        </div>
        @endauth
    </div>
</header>