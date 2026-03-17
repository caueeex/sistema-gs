@extends('layouts.app')

@section('title', $ad->titulo)

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1>{{ $ad->titulo }}</h1>
        <div>
            <a href="{{ route('anuncios.edit', $ad) }}" class="btn btn-success btn-sm">Editar</a>
            <a href="{{ route('anuncios.index') }}" class="btn btn-secondary btn-sm">Voltar</a>
        </div>
    </div>

    <div class="card content-card">
        <div class="card-header">Detalhes</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-2">Descrição</dt>
                <dd class="col-sm-10">{{ $ad->descricao }}</dd>

                <dt class="col-sm-2">Preço de venda</dt>
                <dd class="col-sm-10">R$ {{ number_format($ad->preco_venda, 2, ',', '.') }}</dd>

                <dt class="col-sm-2">Produtos</dt>
                <dd class="col-sm-10">
                    <ul class="list-unstyled mb-0">
                        @foreach($ad->products as $p)
                            <li>
                                <a href="{{ route('produtos.show', $p) }}">{{ $p->nome }}</a>
                                — quantidade: {{ $p->pivot->quantidade }}
                            </li>
                        @endforeach
                    </ul>
                </dd>
            </dl>
        </div>
    </div>

    <form action="{{ route('anuncios.destroy', $ad) }}" method="POST" class="mt-3" onsubmit="return confirm('Excluir este anúncio?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm">Excluir anúncio</button>
    </form>
@endsection
