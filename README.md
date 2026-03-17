# Sistema de Gestão de Produtos e Anúncios

Aplicação web para gestão de **Produtos** e **Anúncios** com integração a APIs externas (ViaCEP e autorização).

## Tecnologias

- **Backend:** Laravel 11+
- **Frontend:** Blade (Laravel) + Bootstrap 5
- **ORM:** Eloquent
- **Banco de dados:** MySQL

## Funcionalidades

- **Autenticação:** login, registro e logout (acesso às demais telas requer login)
- **Dashboard:** página inicial com resumo de produtos e anúncios e links para as listagens
- CRUD completo de Produtos (listar, criar, editar, visualizar, excluir)
- CRUD completo de Anúncios (listar, criar, editar, visualizar, excluir)
- Consulta de CEP via ViaCEP para preenchimento automático do bairro
- Verificação de autorização via API externa antes de criar/editar produto ou anúncio
- Filtros e ordenação nas listagens
- Relacionamento many-to-many entre Anúncios e Produtos (com quantidade na pivot)
- **API JSON** (somente leitura): GET `/api/produtos`, `/api/produtos/{id}`, `/api/anuncios`, `/api/anuncios/{id}`
- **Documentação da API:** página com Swagger UI (OpenAPI 3.0) em `/documentacao-api`

## Requisitos

- PHP 8.2+
- Composer
- MySQL 8+

## Instalação

1. **Clone o repositório**
   ```bash
   git clone <url-do-repositorio> sistema-gs
   cd sistema-gs
   ```

2. **Instale as dependências**
   ```bash
   composer install
   ```

3. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure o banco de dados no `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistema_gs
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

5. **Execute as migrations**
   ```bash
   php artisan migrate
   ```

6. **Popule o banco (opcional)**
   ```bash
   php artisan db:seed
   ```
   - Cria um usuário de teste (`teste@example.com` / senha: `password`), 15 produtos e 100 anúncios.

7. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

Acesse **http://localhost:8000**. Será redirecionado para o login; após entrar, acesse o dashboard. Para testar sem registrar, use o usuário criado pelo seed (ver passo 6).

## Estrutura do projeto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── ProductController.php   # API JSON produtos
│   │   │   └── AdController.php        # API JSON anúncios
│   │   ├── Auth/
│   │   │   └── AuthController.php      # Login, registro, logout
│   │   ├── DashboardController.php
│   │   ├── ProductController.php
│   │   └── AdController.php
│   └── Requests/
│       ├── Auth/
│       │   ├── LoginRequest.php
│       │   └── RegisterRequest.php
│       ├── ProductRequest.php
│       └── AdRequest.php
├── Models/
│   ├── Product.php
│   ├── Ad.php
│   └── User.php
└── Services/
    ├── ViaCepService.php
    └── AuthorizationService.php
```

## Rotas

**Públicas (sem login):**
| Método | URL | Descrição |
|--------|-----|-----------|
| GET | / | Redireciona para login ou dashboard |
| GET | /login | Formulário de login |
| POST | /login | Processa login |
| GET | /register | Formulário de registro |
| POST | /register | Cria conta e faz login |
| GET | /documentacao-api | Documentação da API (Swagger UI) |

**Com autenticação:**
| Método | URL | Descrição |
|--------|-----|-----------|
| POST | /logout | Encerra sessão |
| GET | /dashboard | Dashboard (resumo produtos e anúncios) |
| GET | /produtos | Lista produtos |
| GET | /produtos/create | Formulário novo produto |
| POST | /produtos | Salva produto |
| GET | /produtos/{id} | Exibe produto |
| GET | /produtos/{id}/edit | Formulário editar produto |
| PUT | /produtos/{id} | Atualiza produto |
| DELETE | /produtos/{id} | Exclui produto |
| GET | /anuncios | Lista anúncios |
| GET | /anuncios/create | Formulário novo anúncio |
| POST | /anuncios | Salva anúncio |
| GET | /anuncios/{id} | Exibe anúncio |
| GET | /anuncios/{id}/edit | Formulário editar anúncio |
| PUT | /anuncios/{id} | Atualiza anúncio |
| DELETE | /anuncios/{id} | Exclui anúncio |

**API JSON (somente leitura, sem autenticação):**
| Método | URL | Descrição |
|--------|-----|-----------|
| GET | /api/produtos | Lista produtos (paginado) |
| GET | /api/produtos/{id} | Detalhe do produto |
| GET | /api/anuncios | Lista anúncios (paginado) |
| GET | /api/anuncios/{id} | Detalhe do anúncio |
| GET | /api/openapi.json | Especificação OpenAPI 3.0 |

## Integrações

- **ViaCEP** (`https://viacep.com.br/ws/{cep}/json/`): consulta de CEP para obter o bairro ao criar/editar produto.
- **API de autorização** (`GET https://util.devi.tools/api/v2/authorize`): verificação antes de criar ou editar produto/anúncio. Se a resposta tiver `status: "fail"`, a operação é bloqueada.

## Documentação da API

Acesse **http://localhost:8000/documentacao-api** para visualizar a documentação interativa (Swagger UI) com a spec OpenAPI 3.0. É possível testar os endpoints GET da API diretamente na página.
