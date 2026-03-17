@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Produtos</h1>
        <a href="{{ route('produtos.create') }}" class="btn btn-success">Novo Produto</a>
    </div>

    <form method="GET" class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" value="{{ request('nome') }}" placeholder="Filtrar por nome">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bairro</label>
                    <input type="text" name="bairro" class="form-control" value="{{ request('bairro') }}" placeholder="Filtrar por bairro">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Ordenar por</label>
                    <select name="sort" class="form-select">
                        <option value="nome" {{ request('sort') === 'nome' ? 'selected' : '' }}>Nome</option>
                        <option value="preco" {{ request('sort') === 'preco' ? 'selected' : '' }}>Preço</option>
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

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>CEP</th>
                    <th>Bairro</th>
                    <th width="180">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->nome }}</td>
                        <td>R$ {{ number_format($product->preco, 2, ',', '.') }}</td>
                        <td>{{ $product->cep }}</td>
                        <td>{{ $product->bairro }}</td>
                        <td>
                            <a href="{{ route('produtos.show', $product) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                            <a href="{{ route('produtos.edit', $product) }}" class="btn btn-sm btn-outline-success">Editar</a>
                            <form action="{{ route('produtos.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este produto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Nenhum produto encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection
