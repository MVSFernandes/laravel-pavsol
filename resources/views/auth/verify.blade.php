@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card card-glass p-5 text-center shadow-lg">
                
                <div class="mb-3">
                    <i class="bi bi-shield-lock-fill text-primary-custom" style="font-size: 4rem;"></i>
                </div>

                <h4 class="fw-bold text-white">Autenticação Segura</h4>
                <p class="text-white-50 small mb-4">Enviamos um código de 6 dígitos para o seu email.</p>
                
                <form action="{{ route('verify.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                    
                    <div class="mb-4">
                        <input type="text" name="code" 
                               class="form-control form-control-glass text-center fw-bold fs-3" 
                               placeholder="000000" 
                               maxlength="6" 
                               style="letter-spacing: 8px;" 
                               required>
                    </div>

                    <button class="btn btn-pavsol w-100 py-2">
                        <i class="bi bi-check-lg me-2"></i> VALIDAR ACESSO
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection