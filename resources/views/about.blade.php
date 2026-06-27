@extends('layout')
@section('content')
<div class="container py-5">
    
    <div class="row justify-content-center mb-5 text-center">
        <div class="col-lg-8">
            <div class="mb-2">
                <i class="bi bi-cone-striped text-primary-custom display-1"></i>
            </div>
            <h1 class="fw-bold display-5 text-dark">PAV<span class="text-primary-custom">SOL</span></h1>
            <h4 class="text-secondary fw-light">Soluções Inteligentes para Terraplanagem</h4>
            <p class="lead text-muted mt-3 mx-auto" style="max-width: 600px;">
                Plataforma  para geolocalização de insumos da construção civil, integrando rotas e fornecedores em tempo real.
            </p>
        </div>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-12 text-center mb-2">
            <h6 class="text-uppercase fw-bold text-primary-custom tracking-wide">Equipe de Desenvolvimento</h6>
        </div>

        <div class="col-md-5 col-lg-4">
            <div class="card card-custom h-100 border-0 bg-white shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <div class="d-inline-block bg-dark text-white rounded-circle p-3">
                            <i class="bi bi-person-vcard-fill fs-2"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">Marcos Fernandes</h5>
                    <span class="badge bg-secondary mb-3">Dev</span>
                    <hr class="opacity-10">
                    <ul class="list-unstyled text-start small text-secondary mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-fingerprint me-2"></i><strong>RA:</strong> 220477</li>
                        <li><i class="bi bi-envelope-at me-2"></i>royaxlpass@gmail.com</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-lg-4">
            <div class="card card-custom h-100 border-0 bg-white shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <div class="d-inline-block bg-dark text-white rounded-circle p-3">
                            <i class="bi bi-person-vcard-fill fs-2"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">Ciro Ramos</h5>
                    <span class="badge bg-secondary mb-3">Dev</span>
                    <hr class="opacity-10">
                    <ul class="list-unstyled text-start small text-secondary mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-fingerprint me-2"></i><strong>RA:</strong> 220306</li>
                        <li><i class="bi bi-envelope-at me-2"></i>Cirozinho@gmail.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 pt-5 border-top">
        <div class="col-md-3 text-center mb-4">
            <i class="bi bi-code-square fs-1 text-dark mb-2"></i>
            <h6 class="fw-bold">Laravel 12</h6>
        </div>
        <div class="col-md-3 text-center mb-4">
            <i class="bi bi-google fs-1 text-dark mb-2"></i>
            <h6 class="fw-bold">Google Places API</h6>
        </div>
        <div class="col-md-3 text-center mb-4">
            <i class="bi bi-bootstrap-fill fs-1 text-dark mb-2"></i>
            <h6 class="fw-bold">Bootstrap 5</h6>
        </div>
        <div class="col-md-3 text-center mb-4">
            <i class="bi bi-database-fill fs-1 text-dark mb-2"></i>
            <h6 class="fw-bold">SQLite</h6>
        </div>
    </div>
</div>
@endsection
