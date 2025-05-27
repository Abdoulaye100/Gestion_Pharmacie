@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <section class="container py-4 position-relative">
        <!-- Bande colorée décorative -->
        <div style="position: absolute; top: 0; right: 0; width: 120px; height: 16px; background: linear-gradient(90deg, #0dcaf0 60%, #198754 100%); border-bottom-left-radius: 12px;"></div>
        <div class="mb-5 text-center">
            <h1 class="fw-bold text-success mb-2"><i class="bi bi-speedometer2"></i> Tableau de bord</h1>
        </div>
        <div class="row g-4 mb-4">  
            <!-- Médicaments -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-capsule text-success fs-2"></i>
                            </div>
                            <h5 class="card-title mb-0">Médicaments</h5>
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold fs-4 text-success">152</span> <span class="text-muted">au total</span>
                        </div>
                        <div class="mb-1">
                            <span class="badge bg-warning text-dark">7 en cours de péremption</span>
                        </div>
                        <div>
                            <span class="badge bg-danger">3 en manque de stock</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Catégories -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-tags text-warning fs-2"></i>
                            </div>
                            <h5 class="card-title mb-0">Catégories</h5>
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold fs-4 text-warning">12</span> <span class="text-muted">au total</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ventes -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-cart4 text-info fs-2"></i>
                            </div>
                            <h5 class="card-title mb-0">Ventes</h5>
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold fs-4 text-info">38</span> <span class="text-muted">aujourd'hui</span>
                        </div>
                        <div>
                            <span class="fw-bold fs-5 text-primary">1 245</span> <span class="text-muted">ce mois</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <!-- Utilisateurs -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-people text-success fs-2"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Utilisateurs</h5>
                            <span class="fw-bold fs-4 text-success">5</span> <span class="text-muted">comptes</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Statistiques (graphique simulé) -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="bi bi-graph-up-arrow text-primary me-2"></i> Statistiques</h5>
                        <canvas id="fakeChart" height="120"></canvas>
                        <div class="d-flex justify-content-between mt-3">
                            <span class="badge bg-success">+12% ventes</span>
                            <span class="badge bg-info">+8% stock</span>
                            <span class="badge bg-warning text-dark">-2% ruptures</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Chart.js pour le graphique simulé -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Simulation d'un graphique avec de fausses données
        const ctx = document.getElementById('fakeChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Ventes',
                    data: [12, 19, 14, 17, 22, 28, 24],
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25,135,84,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#e9ecef' } },
                    x: { grid: { color: '#e9ecef' } }
                }
            }
        });
    </script>
@endsection 