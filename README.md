# Teste técnico - Backend

Backend Laravel para o sistema construído para o teste técnico.

## Setup

### Variáveis de Ambiente

Antes de buildar a imagem da aplicação, é necessário gerar as variáveis de ambiente:

```bash
cp .env.example .env
```

### Docker

```bash
docker compose build     # Apenas na primeira vez
docker compose up -d
```

Acesse: `http://localhost:8000/docs/api` para a documentação da API.

### Scripts

```bash
php artisan migrate      # Executar migrations
```

## Documentação da API

A documentação OpenAPI interativa está disponível em: **`http://localhost:8000/docs/api`**

Gerada automaticamente pelo [Scramble](https://scramble.dedoc.co/) a partir das anotações no código.
