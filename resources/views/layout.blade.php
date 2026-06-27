<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PavSol Terraplanagem</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #ff6b00; 
            --primary-hover: #e65100;
            --dark: #1a1a1a;
            --glass-dark: rgba(20, 20, 20, 0.90);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .text-primary-custom { color: var(--primary); }
        .btn-pavsol {
            background-color: var(--primary);
            color: white;
            font-weight: 700;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .btn-pavsol:hover {
            background-color: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 0, 0.3);
        }

        .navbar-custom { background-color: var(--dark); border-bottom: 4px solid var(--primary); }
        .nav-link { color: rgba(255,255,255,0.7) !important; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .nav-link:hover { color: var(--primary) !important; }
        .nav-link.active { color: white !important; font-weight: 700; }
        
        .navbar-toggler { border-color: rgba(255,255,255,0.1); }
        .navbar-toggler:focus { box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25); }

        .auth-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1589939705384-5185137a7f0f?q=80&w=1920&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .card-glass {
            background: var(--glass-dark);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 15px;
        }
        
        .form-control-glass {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            color: white !important;
            font-weight: 500;
        }
        .form-control-glass:focus {
            background: rgba(255,255,255,0.15);
            border-color: var(--primary);
            color: white;
            box-shadow: none;
        }
        .form-control-glass::placeholder { color: rgba(255, 255, 255, 0.7) !important; opacity: 1; }
        .form-label-glass { color: rgba(255,255,255,0.8); font-size: 0.8rem; text-transform: uppercase; font-weight: 700; }

        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .alert-floating {
            min-width: 320px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: slideIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-left: 6px solid;
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }
        
        .alert-success { border-color: #198754; }
        .alert-danger { border-color: #dc3545; }

        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .fade-out {
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.5s ease-in;
        }
    </style>
</head>
<body class="@if(Route::is('login') || Route::is('register') || Route::is('verify')) auth-bg @endif">

    @auth
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="bi bi-cone-striped text-primary-custom fs-3 me-2"></i>
                <div>PAVSOL <span class="text-primary-custom">TERRAPLANAGEM</span></div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center text-center text-lg-start">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}"><i class="bi bi-map-fill me-1"></i> Mapa</a></li>
                    <li class="nav-item"><a href="{{ route('favorites') }}" class="nav-link {{ Route::is('favorites') ? 'active' : '' }}"><i class="bi bi-bookmark-star-fill me-1"></i> Favoritos</a></li>
                    <li class="nav-item"><a href="{{ route('about') }}" class="nav-link {{ Route::is('about') ? 'active' : '' }}"><i class="bi bi-info-circle-fill me-1"></i> Quem Somos</a></li>
                    
                    <li class="nav-item d-none d-lg-block border-start border-secondary mx-3" style="height: 30px;"></li>

                    <li class="nav-item my-3 my-lg-0">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-end text-white-50 small">
                            <div class="text-end me-2">
                                <span class="d-block text-white fw-bold text-uppercase">{{ Auth::user()->name }}</span>
                                <span style="font-size: 0.75rem;">Conectado</span>
                            </div>
                            <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center border border-secondary" style="width: 40px; height: 40px;">
                                <i class="bi bi-person-fill text-primary-custom fs-5"></i>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item ms-lg-3 mb-3 mb-lg-0">
                        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm px-4 rounded-pill fw-bold">
                            <i class="bi bi-box-arrow-right me-1"></i> SAIR
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <main class="flex-grow-1 @if(Route::is('login') || Route::is('register') || Route::is('verify')) d-flex flex-column justify-content-center @else d-block pt-2 @endif">
        
        <div id="toast-container">
            @if(session('success'))
                <div class="alert alert-success alert-floating" role="alert">
                    <i class="bi bi-check-circle-fill text-success fs-3 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Sucesso!</h6>
                        <small class="text-muted">{{ session('success') }}</small>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-floating" role="alert">
                    <i class="bi bi-exclamation-octagon-fill text-danger fs-3 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Atenção!</h6>
                        <small class="text-muted">{{ $errors->first() }}</small>
                    </div>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    @if(!Auth::check())
    <footer class="text-center py-3 text-white fixed-bottom" style="background: rgba(0, 0, 0, 0.71);">
        <small class="opacity-70 text-uppercase tracking-wide">2025 © PavSol Terraplanagem - Todos os Direitos Reservados</small>
    </footer>
    @endif
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const existingAlerts = document.querySelectorAll('.alert-floating');
            existingAlerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.classList.add('fade-out');
                    setTimeout(function() { alert.remove(); }, 500); 
                }, 4000); 
            });
        });

        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const alertDiv = document.createElement('div');
            
            let iconClass = type === 'success' ? 'bi-check-circle-fill text-success' : 'bi-exclamation-octagon-fill text-danger';
            let title = type === 'success' ? 'Sucesso!' : 'Atenção!';
            let borderClass = type === 'success' ? 'alert-success' : 'alert-danger';

            alertDiv.className = `alert ${borderClass} alert-floating`;
            alertDiv.innerHTML = `
                <i class="bi ${iconClass} fs-3 me-3"></i>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">${title}</h6>
                    <small class="text-muted">${message}</small>
                </div>
            `;

            container.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.classList.add('fade-out');
                setTimeout(() => { alertDiv.remove(); }, 500);
            }, 4000);
        }
    </script>
</body>
</html>
