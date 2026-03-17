@extends('layouts.app')

@section('title', $product->nome)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $product->nome }}</h1>
        <div>
            <a href="{{ route('produtos.edit', $product) }}" class="btn btn-success">Editar</a>
            <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-2">Descrição</dt>
                <dd class="col-sm-10">{{ $product->descricao }}</dd>

                <dt class="col-sm-2">Preço</dt>
                <dd class="col-sm-10">R$ {{ number_format($product->preco, 2, ',', '.') }}</dd>

                <dt class="col-sm-2">CEP</dt>
                <dd class="col-sm-10">{{ $product->cep }}</dd>

                <dt class="col-sm-2">Bairro</dt>
                <dd class="col-sm-10">{{ $product->bairro }}</dd>

                @if($product->ads->isNotEmpty())
                    <dt class="col-sm-2">Anúncios</dt>
                    <dd class="col-sm-10">
                        <ul class="list-unstyled mb-0">
                            @foreach($product->ads as $ad)
                                <li><a href="{{ route('anuncios.show', $ad) }}">{{ $ad->titulo }}</a></li>
                            @endforeach
                        </ul>
                    </dd>
                @endif
            </dl>
        </div>
    </div>

    <form action="{{ route('produtos.destroy', $product) }}" method="POST" class="mt-3" onsubmit="return confirm('Excluir este produto?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir produto</button>
    </form>
@endsection
