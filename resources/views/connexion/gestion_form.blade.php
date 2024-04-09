<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Compte</title>

    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png" />

    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/gestion.css">

</head>

<body>
    @include('headfoot/header')

        <form  action="{{route('gestion')}}" method="post">@csrf

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit">Mettre à jour le compte</button>
        </form>

        <div id="info">
            <h5>Bienvenue {{ auth()->user()->name }}</h5>
            <p>Cette page vous permet de changer votre nom d'utilisateur ainsi que votre mot de passe.</p>
        </div>

    
    @include('headfoot/footer')
</body>

</html>
