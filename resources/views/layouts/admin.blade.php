<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .csp{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        span{
            padding: 10px;
            cursor: pointer;
        }
        span a{
            display: block;
            height: 20px;
        }
        span:hover{
            background-color: rgba(128, 128, 128, 0.301);
            transition: 0.5s;
        }

        a{
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; height: 100vh; overflow: hidden">
    <section style="display: flex; flex-direction: column; height: 100%; margin: 0; padding: 0">
        <header class="admin-header" style="background-color: rgba(0, 128, 0, 0.795); color: white; min-height: 10%;display: flex; align-items: center">
                <h1>Gestion de Pharmacie</h1>
        </header>
        <div style="display: flex; min-height: 90%">
            <nav class="admin-nav" style="width: 60%; height: 100%; background: green; max-width:250px; box-shadow: 0 0 16px -10px black;">
                <div class="csp" style="margin-top: 70px">
                    <span><a href="{{ route('dashboard') }}">Dashboard</a></span>
                    <span><a href="{{ route('medicaments') }}">Médicaments</a></span>
                    <span><a href="{{ route('categories') }}">Catégories</a></span>
                    <span><a href="{{ route('ventes') }}">Ventes</a></span>
                    <span><a href="{{ route('factures') }}">Factures</a></span>
                    <span><a href="{{ route('utilisateurs') }}">Utilisateurs</a></span>
                </div>
            </nav>
        
            <main class="admin-content" style="padding: 10px; width: 100%">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 