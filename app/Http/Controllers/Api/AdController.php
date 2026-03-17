<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\JsonResponse;

class AdController extends Controller
{
    public function index(): JsonResponse
    {
        $ads = Ad::with('products')->orderBy('titulo')->paginate(15);
        return response()->json($ads);
    }

    public function show(Ad $ad): JsonResponse
    {
        $ad->load('products');
        return response()->json($ad);
    }
}
