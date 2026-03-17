<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Api\AdController as ApiAdController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('documentacao-api', function () {
    return view('api.documentacao');
})->name('api.documentacao');

Route::get('api/openapi.json', function () {
    return response()->json([
        'openapi' => '3.0.3',
        'info' => [
            'title' => 'Sistema GS - API',
            'description' => 'API de consulta a produtos e anúncios. Endpoints somente leitura (GET).',
            'version' => '1.0.0',
        ],
        'servers' => [['url' => url('/api'), 'description' => 'Servidor atual']],
        'paths' => [
            '/produtos' => [
                'get' => [
                    'summary' => 'Listar produtos',
                    'description' => 'Retorna lista paginada de produtos ordenados por nome.',
                    'tags' => ['Produtos'],
                    'parameters' => [
                        ['name' => 'page', 'in' => 'query', 'description' => 'Página da paginação', 'schema' => ['type' => 'integer', 'default' => 1]],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Lista paginada de produtos',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'data' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/Product']],
                                            'current_page' => ['type' => 'integer'],
                                            'last_page' => ['type' => 'integer'],
                                            'per_page' => ['type' => 'integer'],
                                            'total' => ['type' => 'integer'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/produtos/{id}' => [
                'get' => [
                    'summary' => 'Exibir produto',
                    'description' => 'Retorna um produto pelo ID, incluindo anúncios vinculados.',
                    'tags' => ['Produtos'],
                    'parameters' => [
                        ['name' => 'id', 'in' => 'path', 'required' => true, 'description' => 'ID do produto', 'schema' => ['type' => 'integer']],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Detalhes do produto',
                            'content' => [
                                'application/json' => ['schema' => ['$ref' => '#/components/schemas/ProductDetail']],
                            ],
                        ],
                        '404' => ['description' => 'Produto não encontrado'],
                    ],
                ],
            ],
            '/anuncios' => [
                'get' => [
                    'summary' => 'Listar anúncios',
                    'description' => 'Retorna lista paginada de anúncios ordenados por título, com produtos vinculados.',
                    'tags' => ['Anúncios'],
                    'parameters' => [
                        ['name' => 'page', 'in' => 'query', 'description' => 'Página da paginação', 'schema' => ['type' => 'integer', 'default' => 1]],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Lista paginada de anúncios',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'data' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/Ad']],
                                            'current_page' => ['type' => 'integer'],
                                            'last_page' => ['type' => 'integer'],
                                            'per_page' => ['type' => 'integer'],
                                            'total' => ['type' => 'integer'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/anuncios/{id}' => [
                'get' => [
                    'summary' => 'Exibir anúncio',
                    'description' => 'Retorna um anúncio pelo ID, incluindo produtos vinculados e quantidade.',
                    'tags' => ['Anúncios'],
                    'parameters' => [
                        ['name' => 'id', 'in' => 'path', 'required' => true, 'description' => 'ID do anúncio', 'schema' => ['type' => 'integer']],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Detalhes do anúncio',
                            'content' => [
                                'application/json' => ['schema' => ['$ref' => '#/components/schemas/AdDetail']],
                            ],
                        ],
                        '404' => ['description' => 'Anúncio não encontrado'],
                    ],
                ],
            ],
        ],
        'components' => [
            'schemas' => [
                'Product' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'nome' => ['type' => 'string', 'example' => 'Cubo Mágico 3x3'],
                        'descricao' => ['type' => 'string'],
                        'preco' => ['type' => 'number', 'format' => 'decimal', 'example' => 49.90],
                        'cep' => ['type' => 'string', 'example' => '01310100'],
                        'bairro' => ['type' => 'string', 'example' => 'Bela Vista'],
                        'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                    ],
                ],
                'ProductDetail' => [
                    'allOf' => [
                        ['$ref' => '#/components/schemas/Product'],
                        [
                            'type' => 'object',
                            'properties' => [
                                'ads' => [
                                    'type' => 'array',
                                    'items' => ['$ref' => '#/components/schemas/AdRef'],
                                ],
                            ],
                        ],
                    ],
                ],
                'AdRef' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'titulo' => ['type' => 'string'],
                        'preco_venda' => ['type' => 'number'],
                        'pivot' => ['type' => 'object', 'properties' => ['quantidade' => ['type' => 'integer']]],
                    ],
                ],
                'Ad' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'titulo' => ['type' => 'string', 'example' => 'Cubo mágico 3x3 novo'],
                        'descricao' => ['type' => 'string'],
                        'preco_venda' => ['type' => 'number', 'format' => 'decimal', 'example' => 59.90],
                        'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                        'products' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/ProductRef']],
                    ],
                ],
                'ProductRef' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'nome' => ['type' => 'string'],
                        'preco' => ['type' => 'number'],
                        'pivot' => ['type' => 'object', 'properties' => ['quantidade' => ['type' => 'integer']]],
                    ],
                ],
                'AdDetail' => [
                    'allOf' => [
                        ['$ref' => '#/components/schemas/Ad'],
                    ],
                ],
            ],
        ],
    ])->header('Content-Type', 'application/json');
});

Route::prefix('api')->group(function (): void {
    Route::get('produtos', [ApiProductController::class, 'index']);
    Route::get('produtos/{product}', [ApiProductController::class, 'show']);
    Route::get('anuncios', [ApiAdController::class, 'index']);
    Route::get('anuncios/{ad}', [ApiAdController::class, 'show']);
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('produtos', ProductController::class);
    Route::resource('anuncios', AdController::class);
});
