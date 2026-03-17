@extends('layouts.app')

@section('title', 'Anúncios')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1>Anúncios</h1>
        <a href="{{ route('anuncios.create') }}" class="btn btn-success btn-sm">Novo Anúncio</a>
    </div>

    <form method="GET" class="card filter-card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" value="{{ request('titulo') }}" placeholder="Filtrar por título">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Descrição</label>
                    <input type="text" name="descricao" class="form-control" value="{{ request('descricao') }}" placeholder="Filtrar por descrição">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Produto</label>
                    <select name="produto_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($productsForFilter as $p)
                            <option value="{{ $p->id }}" {{ request('produto_id') == $p->id ? 'selected' : '' }}>{{ $p->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Ordenar por</label>
                    <select name="sort" class="form-select">
                        <option value="titulo" {{ request('sort') === 'titulo' ? 'selected' : '' }}>Título</option>
                        <option value="preco_venda" {{ request('sort') === 'preco_venda' ? 'selected' : '' }}>Preço</option>
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Data</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Ordem</label>
                    <select name="order" class="form-select">
                        <option value="asc" {{ request('order', 'asc') === 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-success w-100">Filtrar</button>
                </div>
            </div>
        </div>
    </form>

    <div class="table-wrapper table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Preço venda</th>
                    <th>Produtos</th>
                    <th width="180">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ads as $ad)
                    <tr>
                        <td>{{ $ad->titulo }}</td>
                        <td>R$ {{ number_format($ad->preco_venda, 2, ',', '.') }}</td>
                        <td>
                            @foreach($ad->products as $p)
                                <span class="badge bg-secondary">{{ $p->nome }} ({{ $p->pivot->quantidade }})</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('anuncios.show', $ad) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <a href="{{ route('anuncios.edit', $ad) }}" class="btn btn-sm btn-outline-success">Editar</a>
                            <form action="{{ route('anuncios.destroy', $ad) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este anúncio?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Nenhum anúncio encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $ads->links('pagination::bootstrap-5') }}
    </div>
@endsection
