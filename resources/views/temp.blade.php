<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page de saise de température</title>
</head>

@include('headfoot/header')


<style>
    h2 {
        text-align: center;
        font-size: 20px;
    }
    
    body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
}

select, input[type="date"], input[type="number"], input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

button:active {
    background-color: #3e8e41;
}
</style>

<body>
    <h2>Bonjour, {{ auth()->user()->name }}, ceci est la page quand on est connecté</h2>
    <form method="post" action="{{ route('deconnexion') }}" style="text-align: center; margin-top: 20px;">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
    <form action="{{ route('ajouter_utilisateur') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="longitude">Longitude:</label>
        <input type="text" class="form-control" id="longitude" name="longitude">
    </div>

    <div class="form-group">
        <label for="latitude">Latitude:</label>
        <input type="text" class="form-control" id="latitude" name="latitude">
    </div>

    <div class="form-group">
        <label for="libelle_commune">Libellé commune:</label>
        <input type="text" class="form-control" id="libelle_commune" name="libelle_commune">
    </div>

    <div class="form-group">
        <label for="libelle_cours_eau">Libellé cours d'eau:</label>
        <input type="text" class="form-control" id="libelle_cours_eau" name="libelle_cours_eau">
    </div>

    <div class="form-group">
        <label for="date_mesure_temp">Date mesure temp:</label>
        <input type="date" class="form-control" id="date_mesure_temp" name="date_mesure_temp">
    </div>

    <div class="form-group">
        <label for="heure_mesure_temp">Heure mesure temp:</label>
        <input type="time" class="form-control" id="heure_mesure_temp" name="heure_mesure_temp">
    </div>

    <div class="form-group">
        <label for="resultat">Résultat:</label>
        <input type="text" class="form-control" id="resultat" name="resultat">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>

@include('headfoot/footer')

</html>
