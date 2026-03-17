<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documentação da API - Sistema GS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() ? route('dashboard') : url('/') }}">Sistema GS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('api.documentacao') ? 'active' : '' }}" href="{{ route('api.documentacao') }}">Documentação API</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('produtos.index') }}">Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('anuncios.index') }}">Anúncios</a>
                        </li>
                    @endauth
                </ul>
                @auth
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <span class="navbar-user" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <span class="navbar-divider d-none d-md-inline-block"></span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout">Sair</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container-fluid px-0">
        <div class="page-header container py-3 mb-0">
            <h1 class="h4 mb-0">Documentação da API (OpenAPI / Swagger)</h1>
            <p class="text-muted small mb-0 mt-1">Endpoints de consulta a produtos e anúncios em JSON</p>
        </div>
        <div id="swagger-ui" class="swagger-ui-wrapper"></div>
    </main>

    <footer class="app-footer text-center container py-2">
        Sistema de gestão de produtos e anúncios
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5.9.0/swagger-ui-bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5.9.0/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            var preset = typeof SwaggerUIStandalonePreset !== 'undefined'
                ? SwaggerUIStandalonePreset
                : SwaggerUIBundle.presets.standalone;
            window.ui = SwaggerUIBundle({
                url: "{{ url('api/openapi.json') }}",
                dom_id: '#swagger-ui',
                presets: [
                    SwaggerUIBundle.presets.apis,
                    preset
                ],
                layout: "StandaloneLayout",
                defaultModelsExpandDepth: -1
            });
        };
    </script>
    <style>
        .swagger-ui-wrapper { min-height: 70vh; }
        .swagger-ui .topbar { display: none; }
    </style>
</body>
</html>
