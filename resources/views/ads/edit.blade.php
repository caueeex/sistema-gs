@extends('layouts.app')

@section('title', 'Editar Anúncio')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Anúncio</h1>
        <a href="{{ route('anuncios.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <form method="POST" action="{{ route('anuncios.update', $ad) }}" id="form-ad">
        @csrf
        @method('PUT')
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $ad->titulo) }}" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea name="descricao" id="descricao" rows="3" class="form-control @error('descricao') is-invalid @enderror" required>{{ old('descricao', $ad->descricao) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="preco_venda" class="form-label">Preço de venda</label>
                    <input type="number" name="preco_venda" id="preco_venda" step="0.01" min="0" class="form-control @error('preco_venda') is-invalid @enderror" value="{{ old('preco_venda', $ad->preco_venda) }}" required>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Produtos do anúncio</span>
                <button type="button" class="btn btn-sm btn-outline-success" id="add-product">Adicionar produto</button>
            </div>
            <div class="card-body">
                <div id="products-container">
                    @php
                        $oldProdutos = old('produtos');
                        if ($oldProdutos === null) {
                            $oldProdutos = $ad->products->map(fn($p) => ['product_id' => $p->id, 'quantidade' => $p->pivot->quantidade])->toArray();
                        }
                        if (empty($oldProdutos)) {
                            $oldProdutos = [['product_id' => '', 'quantidade' => 1]];
                        }
                    @endphp
                    @foreach($oldProdutos as $index => $item)
                        <div class="row g-2 mb-2 product-row">
                            <div class="col-md-6">
                                <select name="produtos[{{ $index }}][product_id]" class="form-select product-select" required>
                                    <option value="">Selecione o produto</option>
                                    @foreach($products as $p)
                                        <option value="{{ $p->id }}" {{ (string)$p->id === (string)($item['product_id'] ?? $item['product_id'] ?? '') ? 'selected' : '' }}>{{ $p->nome }} - R$ {{ number_format($p->preco, 2, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="produtos[{{ $index }}][quantidade]" class="form-control" value="{{ $item['quantidade'] ?? 1 }}" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-product">Remover</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('anuncios.index') }}" class="btn btn-link">Cancelar</a>
    </form>

    @push('scripts')
    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const index = container.querySelectorAll('.product-row').length;
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 product-row';
            row.innerHTML = `
                <div class="col-md-6">
                    <select name="produtos[${index}][product_id]" class="form-select product-select" required>
                        <option value="">Selecione o produto</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->nome }} - R$ {{ number_format($p->preco, 2, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="produtos[${index}][quantidade]" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-product">Remover</button>
                </div>
            `;
            container.appendChild(row);
        });
        document.getElementById('products-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                const row = e.target.closest('.product-row');
                if (document.querySelectorAll('.product-row').length > 1) {
                    row.remove();
                }
            }
        });
    </script>
    @endpush
@endsection
