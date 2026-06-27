@extends('layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-glass p-4 shadow-lg">
                <div class="card-body">
                    <h4 class="text-center mb-4 fw-bold text-white"><i class="bi bi-person-plus me-2"></i>Novo Cadastro</h4>

                    <form action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-glass">Nome Completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-secondary text-white"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control form-control-glass" placeholder="Ex: João Silva" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-glass">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-secondary text-white"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-control-glass" placeholder="exemplo@pavsol.com" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label-glass">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-secondary text-white"><i class="bi bi-key"></i></span>
                                    <input type="password" name="password" class="form-control form-control-glass" placeholder="Mín. 6 dígitos" required>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label-glass">Confirmar</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-secondary text-white"><i class="bi bi-check2-circle"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control form-control-glass" placeholder="Repita a senha" required>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-pavsol w-100 mt-2">CRIAR CONTA</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-white-50 text-decoration-none small"><i class="bi bi-arrow-left"></i> Voltar para Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection