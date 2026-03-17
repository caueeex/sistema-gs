@extends('layouts.app')

@section('title', 'Novo Produto')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Novo Produto</h1>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <form method="POST" action="{{ route('produtos.store') }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="3" class="form-control @error('descricao') is-invalid @enderror" required>{{ old('descricao') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label">Preço</label>
                    <input type="number" name="preco" id="preco" step="0.01" min="0" class="form-control @error('preco') is-invalid @enderror" value="{{ old('preco') }}" required>
                </div>
                <div class="mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror" value="{{ old('cep') }}" placeholder="00000-000" required>
                    <small class="text-muted">O bairro será preenchido automaticamente pela consulta ao CEP.</small>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('produtos.index') }}" class="btn btn-link">Cancelar</a>
            </div>
        </div>
    </form>
@endsection
