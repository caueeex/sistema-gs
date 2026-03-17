<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::orderBy('nome')->paginate(15);
        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('ads');
        return response()->json($product);
    }
}
