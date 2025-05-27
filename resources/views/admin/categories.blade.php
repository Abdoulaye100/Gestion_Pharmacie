@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
    <section class="container py-4 position-relative">
        <!-- Bande colorée décorative -->
        <div style="position: absolute; top: 0; right: 0; width: 120px; height: 16px; background: linear-gradient(90deg, #ffc107 60%, #ff9800 100%); border-bottom-left-radius: 12px;"></div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-success">Liste des catégories</h1>
            <button class="btn btn-success shadow-sm"><i class="bi bi-plus-circle"></i> Ajouter une catégorie</button>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" action="" method="GET">
                    <input type="text" class="form-control me-2" placeholder="Rechercher une catégorie...">
                    <button class="btn btn-outline-success" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
        <div class="table-responsive rounded shadow-sm bg-white p-3">
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">Antibiotiques</td>
                        <td class="text-muted">Médicaments contre les infections bactériennes</td>
                        <td>01/05/2024</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm me-1"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Anti-douleurs</td>
                        <td class="text-muted">Soulagement de la douleur</td>
                        <td>01/05/2024</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm me-1"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
