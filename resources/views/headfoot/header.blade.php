<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffffff;
        color: #333;
        line-height: 1.6;
    }

    header {
        background-color: #2368D1;
        padding: 15px;
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        height: 30px; 
    }

    .login-btn {
        padding: 6px 15px;
        background-color: #fff;
        color: #0d2a63;
        text-decoration: none;
        border-radius: 10px;
    }

    .titre{
        color:rgb(255, 255, 255);
        font-size: 25px;
    }

    .hide-button .login-btn {
        display: none;
    }
</style>


<body>
    <header class="@yield('header-class', '')">
        <h1 class="titre">AquaVigilance</h1>
        <a href="{{route('connexion')}}" class="login-btn">Connexion</a>
    </header>
</body>
