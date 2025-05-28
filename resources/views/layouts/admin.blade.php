<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #198754 60%, #43e97b 100%);
            min-height: 100vh;
            color: #fff;
            box-shadow: 0 0 16px -10px #00000044;
        }
        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: background 0.2s;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }
        .sidebar .bi {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        .admin-header {
            background: linear-gradient(90deg, #198754 70%, #43e97b 100%);
            color: #fff;
            min-height: 70px;
            display: flex;
            align-items: center;
            padding-left: 30px;
            box-shadow: 0 2px 8px -4px #00000022;
        }
        .admin-content::-webkit-scrollbar {
            width: 8px;
        }
        .admin-content::-webkit-scrollbar-thumb {
            background: #000;
            border-radius: 6px;
        }
        .admin-content::-webkit-scrollbar-track {
            background: #e9ecef;
            border-radius: 6px;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; height: 100vh; overflow: hidden">
    <section style="display: flex; flex-direction: column; height: 100%; margin: 0; padding: 0">
        <header class="admin-header d-flex justify-content-between align-items-center">
            <h1 class="fw-bold mb-0"><i class="bi bi-capsule-pill me-2"></i>Gestion de Pharmacie</h1>
            <span class="badge rounded-pill bg-success fs-6 px-4 py-2 shadow-sm" style="letter-spacing:1px; font-weight:600; margin-right: 30px; background: linear-gradient(90deg, #198754 70%, #43e97b 100%); color: #fff;"><i class="bi bi-person-gear me-1"></i> Admin</span>
        </header>
        <div style="display: flex; min-height: 90%">
            <nav class="sidebar d-flex flex-column p-4" style="width: 60%; max-width:250px;">
                <ul class="nav flex-column mt-4">
                    <li class="nav-item mb-2">
                        <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link @if(request()->routeIs('medicaments')) active @endif" href="{{ route('medicaments') }}">
                            <i class="bi bi-capsule"></i> Médicaments
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link @if(request()->routeIs('categories')) active @endif" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags"></i> Catégories
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link @if(request()->routeIs('ventes')) active @endif" href="{{ route('ventes') }}">
                            <i class="bi bi-cart4"></i> Ventes
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link @if(request()->routeIs('utilisateurs')) active @endif" href="{{ route('utilisateurs') }}">
                            <i class="bi bi-people"></i> Utilisateurs
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link @if(request()->routeIs('fournisseurs')) active @endif" href="{{ route('fournisseurs.index') }}">
                            <i class="bi bi-truck"></i> Fournisseurs
                        </a>
                    </li>
                </ul>
            </nav>
            <main class="admin-content" style="padding: 10px; width: 100%; height: 100vh; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #43e97b #e9ecef;">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 