<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\AuthorizationService;
use App\Services\ViaCepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private ViaCepService $viaCepService,
        private AuthorizationService $authorizationService
    ) {
    }

    public function index(Request $request): View
    {
        $query = Product::query();

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('bairro')) {
            $query->where('bairro', 'like', '%' . $request->bairro . '%');
        }

        $sortField = $request->get('sort', 'nome');
        $sortOrder = $request->get('order', 'asc');

        if (in_array($sortField, ['nome', 'preco', 'created_at'])) {
            $query->orderBy($sortField, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        $products = $query->paginate(15)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $auth = $this->authorizationService->isAuthorized();
        if (!$auth['authorized']) {
            return back()->withInput()->with('error', $auth['message']);
        }

        $result = $this->viaCepService->buscarBairroPorCep($request->cep);
        if (!$result['success']) {
            return back()->withInput()->with('error', $result['message']);
        }

        Product::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'cep' => $result['cep'],
            'bairro' => $result['bairro'],
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso.');
    }

    public function show(Product $produto): View
    {
        $produto->load('ads');
        return view('products.show', ['product' => $produto]);
    }

    public function edit(Product $produto): View
    {
        return view('products.edit', ['product' => $produto]);
    }

    public function update(ProductRequest $request, Product $produto): RedirectResponse
    {
        $auth = $this->authorizationService->isAuthorized();
        if (!$auth['authorized']) {
            return back()->withInput()->with('error', $auth['message']);
        }

        $result = $this->viaCepService->buscarBairroPorCep($request->cep);
        if (!$result['success']) {
            return back()->withInput()->with('error', $result['message']);
        }

        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'cep' => $result['cep'],
            'bairro' => $result['bairro'],
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $produto): RedirectResponse
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso.');
    }
}
