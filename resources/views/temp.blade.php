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
    button {
        background-color: #2368D1;
        color: #fff;
        padding: 8px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        width: 10%;
        margin-top: 20px;
        font-size: 16px;
    }

</style>

<body>
    <h2>Bonjour, {{ auth()->user()->name }}, ceci est la page quand on est connecté</h2>
    <form method="post" action="{{ route('deconnexion') }}" style="text-align: center; margin-top: 20px;">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
</body>

@include('headfoot/footer')

</html>
