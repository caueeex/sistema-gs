@extends('layouts.app')

@section('title', 'Início')

@section('content')
    <div class="page-header">
        <h1>Dashboard</h1>
        <p class="text-muted mb-0 mt-1 small">Visão geral de produtos e anúncios</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <a href="{{ route('produtos.index') }}" class="text-decoration-none text-dark">
                <div class="card content-card h-100 dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total de produtos</p>
                            <p class="h4 mb-0 fw-semibold">{{ $totalProdutos }}</p>
                        </div>
                        <span class="text-success fs-4">→</span>
                    </div>
                    <div class="card-footer py-2">
                        <span class="small text-muted">Ver todos os produtos</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('anuncios.index') }}" class="text-decoration-none text-dark">
                <div class="card content-card h-100 dashboard-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total de anúncios</p>
                            <p class="h4 mb-0 fw-semibold">{{ $totalAnuncios }}</p>
                        </div>
                        <span class="text-success fs-4">→</span>
                    </div>
                    <div class="card-footer py-2">
                        <span class="small text-muted">Ver todos os anúncios</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card content-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Últimos produtos</span>
                    <a href="{{ route('produtos.index') }}" class="btn btn-sm btn-outline-success">Ver todos</a>
                </div>
                <div class="card-body p-0">
                    @if($ultimosProdutos->isEmpty())
                        <p class="text-muted small mb-0 p-3">Nenhum produto cadastrado.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($ultimosProdutos as $p)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                                    <a href="{{ route('produtos.show', $p) }}" class="text-decoration-none text-dark">{{ $p->nome }}</a>
                                    <span class="small text-muted">R$ {{ number_format($p->preco, 2, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card content-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Últimos anúncios</span>
                    <a href="{{ route('anuncios.index') }}" class="btn btn-sm btn-outline-success">Ver todos</a>
                </div>
                <div class="card-body p-0">
                    @if($ultimosAnuncios->isEmpty())
                        <p class="text-muted small mb-0 p-3">Nenhum anúncio cadastrado.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($ultimosAnuncios as $a)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                                    <a href="{{ route('anuncios.show', $a) }}" class="text-decoration-none text-dark">{{ $a->titulo }}</a>
                                    <span class="small text-muted">R$ {{ number_format($a->preco_venda, 2, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
