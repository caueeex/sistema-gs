<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProdutos = Product::count();
        $totalAnuncios = Ad::count();

        $ultimosProdutos = Product::latest()->take(5)->get();
        $ultimosAnuncios = Ad::with('products')->latest()->take(5)->get();

        return view('dashboard.index', [
            'totalProdutos' => $totalProdutos,
            'totalAnuncios' => $totalAnuncios,
            'ultimosProdutos' => $ultimosProdutos,
            'ultimosAnuncios' => $ultimosAnuncios,
        ]);
    }
}
