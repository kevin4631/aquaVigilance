<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Temperature</title>

    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png" />

    <link rel="stylesheet" href="css/historique.css">
    <link rel="stylesheet" href="css/footer.css"/>
    <link rel="stylesheet" href="css/header.css" />

</head>
<body>
    @include('headfoot/header')

    <h1>Historique des Températures</h1>
    <div class="button-container">
        <a href="{{route('accueil')}}" class="accueil-btn">accueil</a>
        <a href="{{route('temp_formulaire')}}" class="temperature-btn">Page Temperature</a>
        <a href="{{route('deconnexion')}}" class="deco-btn">Déconnexion</a>
    </div>

    <div class="container">
        
    @if($temperatures->isEmpty())
    <p>Aucune donnée de température trouvée.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Date de mesure</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Commune</th>
                <th>Cours d'eau</th>
                <th>Temperature en C°</th>
            </tr>
        </thead>
        <tbody>
            @foreach($temperatures as $temperature)
                <tr>
                    <td>{{ $temperature->date_mesure_temp }}</td>
                    <td>{{ $temperature->longitude }}</td>
                    <td>{{ $temperature->latitude }}</td>
                    <td>{{ $temperature->libelle_commune }}</td>
                    <td>{{ $temperature->libelle_cours_eau }}</td>
                    <td>{{ $temperature->resultat }}</td>
                    <td>
                        <a id="Suppression" class="icon" href="{{ route('temperature.supprimer', $temperature->id) }}"> <img src="/img/poubelle.png"></a>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
    </div>

    @include('headfoot/footer')
</body>
</html>
