<!DOCTYPE html>
<html lang="en">

<style>

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        justify-content: flex-start;
        background-image: url('img/background.jpg'); 
        background-size: cover;
    }

    .creation_div {
        position:absolute;
        top: 50%;
        left: 50%;
        margin-top:-185px;
        margin-left: -195px;
    }
    

    .creation_form {
        background-color: rgba(255, 255, 255, 0.982); 
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 0;
        width: 330px;
        height: 330px;
        text-align: center;
    }

    h1 {
        color: #2368D1;
        font-size: 24px;
        margin-bottom: 20px;
    }

    input {
        width: calc(100% - 20px);
        padding: 12px;
        margin: 10px 0;
        box-sizing: border-box;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 14px;
    }

    button {
        background-color: #2368D1;
        color: #fff;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        width: 78%;
        margin-top: 20px;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: #dc3545;
        margin-top: 10px;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    @include('headfoot/header')
</head>

    @foreach ($errors->all() as $error)
    {{$error}}
    @endforeach

 <body>
    <div class="creation_div">
        <form class="creation_form"  action="{{route('reset')}}" method="post">@csrf
        <h1>Changement de mot de passe</h1>
        <input type="email" name="email" placeholder="adresse mail">
        <input type="password" name="password" placeholder=" nouveau mot de passe">
        <button type="submit">Changer le mot de passe</button>
    </form>
    </div>
 </body>   

 @include('headfoot/footer')



</html>
