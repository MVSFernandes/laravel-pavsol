@extends('layout')

@section('content')
<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-2">
        <div>
            <h2 class="fw-bold text-dark mb-0"><i class="bi bi-bookmark-star-fill text-primary-custom me-2"></i>Meus Fornecedores</h2>
            <p class="text-muted mb-0 small">Gerencie e entre em contato com suas lojas salvas.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark fw-bold btn-sm">
            <i class="bi bi-map-fill me-2"></i>VOLTAR AO MAPA
        </a>
    </div>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        
        @foreach($stores as $store)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 position-relative" style="border-left: 5px solid var(--primary) !important;">
                <div class="card-body d-flex flex-column">
                    
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title fw-bold text-dark w-75">{{ $store->name }}</h5>
                        <div class="bg-light rounded-circle p-2 text-primary-custom">
                            <i class="bi bi-shop fs-4"></i>
                        </div>
                    </div>
                    
                    <p class="card-text text-secondary small flex-grow-1">
                        <i class="bi bi-geo-alt-fill text-muted me-1"></i> {{ Str::limit($store->address, 80) }}
                    </p>

                    <div class="d-grid gap-2 mt-3">
                        
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $store->phone);
                        @endphp

                        @if($cleanPhone)
                            <a href="https://wa.me/{{ $cleanPhone }}?text=Olá, vim pelo PavSol e gostaria de um orçamento." 
                               target="_blank" 
                               class="btn btn-success fw-bold text-white btn-sm">
                                <i class="bi bi-whatsapp me-2"></i>Chamar no Zap
                            </a>
                        @else
                            <button class="btn btn-secondary fw-bold btn-sm" disabled title="Telefone não disponível">
                                <i class="bi bi-whatsapp me-2"></i>Sem Zap
                            </button>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $store->latitude }},{{ $store->longitude }}" 
                               target="_blank" 
                               class="btn btn-dark flex-grow-1 btn-sm">
                                <i class="bi bi-cursor-fill me-1"></i> Rota
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="openDeleteModal('{{ route('favorites.delete', $store->id) }}', '{{ $store->name }}')">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-white border-0 text-muted small pt-0 pb-3">
                    <i class="bi bi-calendar-check me-1"></i> Salvo em: {{ $store->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>
        @endforeach

    </div>
    
    @if($stores->isEmpty())
        <div class="text-center py-5 my-5 bg-white rounded-4 shadow-sm">
            <i class="bi bi-clipboard-data text-secondary opacity-25" style="font-size: 5rem;"></i>
            <h4 class="text-dark mt-3 fw-bold">Sua lista está vazia</h4>
            <p class="text-muted">Faça uma busca no mapa e salve fornecedores para eles aparecerem aqui.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-pavsol btn-lg mt-3 px-5">
                <i class="bi bi-search me-2"></i>BUSCAR AGORA
            </a>
        </div>
    @endif

</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4 text-center">
                <div class="mb-3 text-danger">
                    <i class="bi bi-exclamation-circle-fill" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-bold mb-2">Tem certeza?</h5>
                <p class="text-muted mb-4">Você está prestes a remover o fornecedor <br><strong id="storeNameTarget" class="text-dark"></strong> da sua lista.</p>
                
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light fw-bold w-50" data-bs-dismiss="modal">CANCELAR</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger fw-bold w-50">
                        <i class="bi bi-trash3-fill me-2"></i>SIM, REMOVER
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(url, storeName) {
        document.getElementById('storeNameTarget').innerText = storeName;
        
        document.getElementById('confirmDeleteBtn').href = url;
        
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }
</script>

@endsection