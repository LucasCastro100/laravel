# ClubTem

Sistema web construído com o **Laravel 13 React Starter Kit** — Inertia 3, React 19, TypeScript, Tailwind 4 e shadcn/ui. Interface fixa em **pt-BR**.

## Funcionalidades

- **Autenticação** (Laravel Fortify): registro, login, logout, recuperação de senha e verificação de e-mail
- **Passkeys** (WebAuthn): login sem senha
- **Autenticação de dois fatores** (2FA/TOTP): QR Code, confirmação e códigos de recuperação
- **Painel** autenticado em `/dashboard`
- **Configurações**: perfil, segurança e aparência (tema claro/escuro/sistema)
- **SSR** do Inertia (server-side rendering)
- Equipes e convites de membros (código presente, mas **rotas desativadas** — ver `routes/settings.php`)

> Veja o funcionamento completo de cada módulo em [`FUNCIONAMENTO.txt`](./FUNCIONAMENTO.txt).

## Stack

| Camada   | Tecnologia |
|----------|------------|
| Backend  | PHP 8.4, Laravel 13, Laravel Fortify, Inertia Laravel v3 |
| Frontend | Inertia v3, React 19, TypeScript, Tailwind 4, shadcn/ui, Lucide, Sonner |
| Banco    | SQLite (padrão) |
| Build    | Vite, Wayfinder, React Compiler |
| Testes   | Pest |

## Requisitos

- PHP >= 8.3 (projeto configurado para 8.4)
- Composer
- Node.js + npm

## Instalação

```bash
composer install
cp .env.example .env          # ou rode o setup abaixo
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run build
```

Ou use o script do composer:

```bash
composer run setup
```

## Desenvolvimento

```bash
composer run dev
```

Isso sobe o servidor Laravel em `http://localhost:8000` e o Vite (com SSR automático em dev).

### Scripts úteis

| Comando | Descrição |
|---------|-----------|
| `npm run dev` | Vite em modo dev |
| `npm run build` | Build de produção (client) |
| `npm run build:ssr` | Build de produção + bundle SSR (`bootstrap/ssr/ssr.js`) |
| `npm run lint` | ESLint com correção |
| `npm run types:check` | Checagem de tipos TypeScript |
| `vendor/bin/pint` | Formatação do código PHP |
| `php artisan test --compact` | Suíte de testes (Pest) |

## Estrutura

```
app/
  Actions/Fortify        Criação de usuário e reset de senha
  Actions/Teams          Criação de equipes
  Concerns/              HasTeams, regras de validação, slugs
  Enums/                 TeamRole, TeamPermission
  Models/                User, Team, Membership, TeamInvitation
  Http/Controllers       Dashboard, Settings/*, Teams/*
resources/js/
  pages/                 Páginas (welcome, dashboard, auth, settings, teams)
  layouts/               App, Auth, Settings
  components/            UI (shadcn) e componentes de domínio
  hooks/                 use-appearance, use-two-factor-auth, ...
  ssr.tsx                Entry do SSR
  app.tsx                Entry do client
routes/
  web.php                Rotas públicas + dashboard
  settings.php           Configurações (rotas de equipe comentadas)
```

## Ambiente

Configuração relevante no `.env`:

- `APP_LOCALE=pt_BR`, `APP_FALLBACK_LOCALE=pt_BR`, `APP_FAKER_LOCALE=pt_BR`
- `DB_CONNECTION=sqlite`
- `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`
- `MAIL_MAILER=log` (e-mails em `storage/logs` no dev)

## Testes

```bash
php artisan test --compact
```

**Atenção:** testes de equipes (ex.: `TeamInvitationTest`, `DashboardTest::pendingInvitations`)
falham de propósito — as rotas de equipes estão desativadas em `routes/settings.php`.

## Licença

MIT — framework Laravel ([licença MIT](https://opensource.org/licenses/MIT)).
