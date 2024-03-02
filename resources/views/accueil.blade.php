<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaVigilance</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        h1 {
            text-align: center;
            font-size: 80px;
        }
    </style>
</head>

<body>
    @include('headfoot/header')

    @include('carte/map')

    @include('headfoot/footer')
</body>

</html>
