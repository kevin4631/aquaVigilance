<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de saisie de température</title>

    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/page_saisie_temp.css">
    <link rel="stylesheet" href="css/page_saisie_temp.css">


</head>

<body>
    @include('headfoot/header')

    <a class="buttonHistorique" href="{{route('historique')}}">Historique des Temperatures</a>

    <form action="{{ route('saisir_temp') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="longitude">Longitude:</label>
            <input type="number" class="form-control" id="longitude" name="longitude" required>
        </div>

        <div class="form-group">
            <label for="latitude">Latitude:</label>
            <input type="number" class="form-control" id="latitude" name="latitude" required>
        </div>

        <div class="form-group">
            <label for="libelle_commune">Commune:</label>
            <input type="text" class="form-control" id="libelle_commune" name="libelle_commune" required>
        </div>

        <div class="form-group">
            <label for="libelle_cours_eau">Cours d'eau:</label>
            <select class="form-control" id="libelle_cours_eau" name="libelle_cours_eau" required>
                <option value="">Choisir un cours d'eau</option>
                @foreach($cours_eaux as $cours_eau)
                <option>{{ $cours_eau->libelle }}</option>
                @endforeach
            </select>
        </div>
        

    <div class="form-group">
        <label for="date_mesure_temp">Date mesure temp:</label>
        <input type="date" class="form-control" id="date_mesure_temp" name="date_mesure_temp" required min="{{ date('Y-m-d') }}">
    </div>

        <div class="form-group">
            <label for="heure_mesure_temp">Heure mesure temp:</label>
            <input type="time" class="form-control" id="heure_mesure_temp" name="heure_mesure_temp" required>
        </div>

        <div class="form-group">
            <label for="resultat">Temperature en C° :</label>
            <input type="number" class="form-control" id="resultat" name="resultat" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>

    <div id="info">
        <h5>Bienvenue {{ auth()->user()->name }} sur notre page de Température</h5>
        <p>Cette page vous permet de saisir les données de température pour différents emplacements. Que vous soyez un météorologue, un chercheur en environnement ou simplement curieux des conditions météorologiques locales, notre outil de saisie de température vous offre une solution conviviale pour enregistrer et analyser les données de température.</p>
    </div>



    @include('headfoot/footer')

</body>

</html>