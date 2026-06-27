@extends('layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="text-center mb-4">
                <i class="bi bi-cone-striped text-primary-custom" style="font-size: 3rem;"></i>
                <h2 class="fw-bold text-white mt-2">PAV<span class="text-primary-custom">SOL</span></h2>
                <p class="text-white-50 small">Acesso ao Sistema</p>
            </div>

            <div class="card card-glass p-4 shadow-lg">
                <div class="card-body">
                    
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-glass">Email Corporativo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-secondary text-white"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-control-glass" placeholder="seu@email.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label-glass">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-secondary text-white"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control form-control-glass" placeholder="••••••" required>
                            </div>
                        </div>
                        <button class="btn btn-pavsol w-100 py-2 mb-3">
                            ENTRAR <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </form>
                    
                    <div class="text-center border-top border-secondary pt-3">
                        <a href="{{ route('register') }}" class="text-white-50 text-decoration-none small">Novo aqui? <span class="text-white fw-bold">Criar Conta</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection