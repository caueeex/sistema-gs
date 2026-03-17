# Sistema de Gestão de Produtos e Anúncios

Aplicação web para gestão de **Produtos** e **Anúncios** com integração a APIs externas (ViaCEP e autorização).

## Tecnologias

- **Backend:** Laravel 11+
- **Frontend:** Blade (Laravel) + Bootstrap 5
- **ORM:** Eloquent
- **Banco de dados:** MySQL

## Funcionalidades

- CRUD completo de Produtos (listar, criar, editar, visualizar, excluir)
- CRUD completo de Anúncios (listar, criar, editar, visualizar, excluir)
- Consulta de CEP via ViaCEP para preenchimento automático do bairro
- Verificação de autorização via API externa antes de criar/editar produto ou anúncio
- Filtros e ordenação nas listagens
- Relacionamento many-to-many entre Anúncios e Produtos (com quantidade na pivot)

## Requisitos

- PHP 8.2+
- Composer
- MySQL 8+
- Extensões PHP: pdo_mysql, mbstring, openssl, json, ctype, fileinfo

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
   - Cria 15 produtos e 100 anúncios com dados de exemplo.

7. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

Acesse: **http://localhost:8000**

## Estrutura do projeto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProductController.php
│   │   └── AdController.php
│   └── Requests/
│       ├── ProductRequest.php
│       └── AdRequest.php
├── Models/
│   ├── Product.php
│   └── Ad.php
└── Services/
    ├── ViaCepService.php      # Integração ViaCEP
    └── AuthorizationService.php  # Integração API de autorização
```

## Rotas

| Método | URL | Descrição |
|--------|-----|-----------|
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

## Integrações

- **ViaCEP** (`https://viacep.com.br/ws/{cep}/json/`): consulta de CEP para obter o bairro ao criar/editar produto.
- **API de autorização** (`GET https://util.devi.tools/api/v2/authorize`): verificação antes de criar ou editar produto/anúncio. Se a resposta tiver `status: "fail"`, a operação é bloqueada.
