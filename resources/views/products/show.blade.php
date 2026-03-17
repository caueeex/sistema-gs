@extends('layouts.app')

@section('title', $product->nome)

@section('content')
    <nav class="mb-3">
        <a href="{{ route('produtos.index') }}" class="text-muted small text-decoration-none">Produtos</a>
        <span class="text-muted small mx-1">/</span>
        <span class="small">{{ $product->nome }}</span>
    </nav>

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h1 class="mb-0">{{ $product->nome }}</h1>
        <div class="d-flex gap-1">
            <a href="{{ route('produtos.edit', $product) }}" class="btn btn-success btn-sm">Editar</a>
            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card content-card">
                <div class="card-header">Informações do produto</div>
                <div class="card-body">
                    <div class="product-detail-row">
                        <span class="product-detail-label">Descrição</span>
                        <span class="product-detail-value">{{ $product->descricao }}</span>
                    </div>
                    <div class="product-detail-row">
                        <span class="product-detail-label">Preço</span>
                        <span class="product-detail-value fw-semibold">R$ {{ number_format($product->preco, 2, ',', '.') }}</span>
                    </div>
                    <div class="product-detail-row">
                        <span class="product-detail-label">Localização</span>
                        <span class="product-detail-value">{{ $product->bairro }} — CEP {{ $product->cep }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card content-card">
                <div class="card-header">Resumo</div>
                <div class="card-body">
                    <p class="mb-2 small text-muted">Este produto está vinculado a</p>
                    <p class="h5 mb-0">{{ $product->ads->count() }} {{ $product->ads->count() === 1 ? 'anúncio' : 'anúncios' }}</p>
                </div>
            </div>

            <div class="card content-card mt-4">
                <div class="card-body">
                    <p class="small text-muted mb-2">Ações</p>
                    <form action="{{ route('produtos.destroy', $product) }}" method="POST" onsubmit="return confirm('Excluir este produto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">Excluir produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($product->ads->isNotEmpty())
        <div class="card content-card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Anúncios que utilizam este produto</span>
                <a href="{{ route('anuncios.index') }}" class="btn btn-sm btn-outline-success">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($product->ads as $ad)
                        <a href="{{ route('anuncios.show', $ad) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                            <span>{{ $ad->titulo }}</span>
                            <span class="badge bg-success rounded-pill">R$ {{ number_format($ad->preco_venda, 2, ',', '.') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
