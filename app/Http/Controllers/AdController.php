<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\Product;
use App\Services\AuthorizationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdController extends Controller
{
    public function __construct(
        private AuthorizationService $authorizationService
    ) {
    }

    public function index(Request $request): View
    {
        $query = Ad::query()->with('products');

        if ($request->filled('titulo')) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }

        if ($request->filled('produto_id')) {
            $query->whereHas('products', function ($q) use ($request) {
                $q->where('products.id', $request->produto_id);
            });
        }

        $sortField = $request->get('sort', 'titulo');
        $sortOrder = $request->get('order', 'asc');

        if (in_array($sortField, ['titulo', 'preco_venda', 'created_at'])) {
            $query->orderBy($sortField, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        $ads = $query->paginate(15)->withQueryString();
        $productsForFilter = Product::orderBy('nome')->get();

        return view('ads.index', compact('ads', 'productsForFilter'));
    }

    public function create(): View
    {
        $products = Product::orderBy('nome')->get();
        return view('ads.create', compact('products'));
    }

    public function store(AdRequest $request): RedirectResponse
    {
        $auth = $this->authorizationService->isAuthorized();
        if (!$auth['authorized']) {
            return back()->withInput()->with('error', $auth['message']);
        }

        $ad = Ad::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco_venda' => $request->preco_venda,
        ]);

        $sync = [];
        foreach ($request->produtos as $item) {
            $sync[$item['product_id']] = ['quantidade' => $item['quantidade']];
        }
        $ad->products()->sync($sync);

        return redirect()->route('anuncios.index')->with('success', 'Anúncio criado com sucesso.');
    }

    public function show(Ad $anuncio): View
    {
        $anuncio->load('products');
        return view('ads.show', ['ad' => $anuncio]);
    }

    public function edit(Ad $anuncio): View
    {
        $anuncio->load('products');
        $products = Product::orderBy('nome')->get();
        return view('ads.edit', ['ad' => $anuncio, 'products' => $products]);
    }

    public function update(AdRequest $request, Ad $anuncio): RedirectResponse
    {
        $auth = $this->authorizationService->isAuthorized();
        if (!$auth['authorized']) {
            return back()->withInput()->with('error', $auth['message']);
        }

        $anuncio->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco_venda' => $request->preco_venda,
        ]);

        $sync = [];
        foreach ($request->produtos as $item) {
            $sync[$item['product_id']] = ['quantidade' => $item['quantidade']];
        }
        $anuncio->products()->sync($sync);

        return redirect()->route('anuncios.index')->with('success', 'Anúncio atualizado com sucesso.');
    }

    public function destroy(Ad $anuncio): RedirectResponse
    {
        $anuncio->delete();
        return redirect()->route('anuncios.index')->with('success', 'Anúncio excluído com sucesso.');
    }
}
