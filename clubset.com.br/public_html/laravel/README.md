# ClubTem

Sistema web construído com o **Laravel 13 React Starter Kit** — Inertia 3, React 19, TypeScript, Tailwind 4 e shadcn/ui. Interface fixa em **pt-BR**.

Marketplace de permuta para o mercado audiovisual: anúncios de equipamento, serviços de produção, matches (interesse) para troca direta, venda ou permuta por créditos, e disputas resolvidas pelo administrador — com assinaturas e cobrança recorrente via Stripe.

## Como o sistema funciona

**Contas e acesso**
- Cadastro, login, recuperação de senha, verificação de e-mail, **passkeys** (WebAuthn) e **2FA** (TOTP) via Laravel Fortify.
- Quatro tipos de usuário (roles): **videomaker** (padrão), **cliente**, **empresa** e **administrador**. O admin é promovido com `php artisan app:make-admin {email}`.
- Cadastros de usuário só ficam "validados" quando um administrador aprova (`admin_verified_at`).

**Localização**
- Estados e municípios do Brasil são importados da API do IBGE com `php artisan app:import-ibge-locations`; usuários, anúncios e serviços apontam para estado/município.

**Marketplace**
1. **Anúncios de equipamento** — o usuário oferece ou procura equipamento (câmera, lente, áudio, iluminação, drone, etc.) para permuta, venda ou ambos. Anúncios novos e editados passam por **moderação do administrador** antes de ficarem públicos.
2. **Serviços** — o profissional publica um serviço (filmagem, edição, fotografia, streaming...) com tarifa por hora/diária ou permuta. Nasce ativo, sem moderação.
3. **Matches** — ao achar um anúncio/serviço, o usuário manifesta interesse (seeker → provider) escolhendo **permuta direta**, **permuta por crédito** ou **venda**, com preço negociado e mensagem. O provider aceita, recusa ou o interessado cancela.
4. **Créditos** — permuta por crédito usa um livro-razão (ledger): ao concluir o match, o sistema transfere automaticamente os créditos do seeker para o provider (saldo insuficiente impede a conclusão).
5. **Disputas** — se algo der errado, o participante abre uma disputa e o administrador resolve ou arquiva.

**Planos e cobranças**
- Assinaturas **trial** (grátis) / **pro** / **max** com checkout no **Stripe** (Laravel Cashier 16).
- Webhooks processam pagamento aprovado/falho; conta em atraso há mais de 7 dias é **bloqueada automaticamente** até regularizar.

**Administração** (`/admin`)
- Painel com métricas (usuários, anúncios pendentes, matches, disputas, créditos em circulação), validação de cadastros e moderação de anúncios.

> Veja o funcionamento detalhado de cada módulo em [`FUNCIONAMENTO.txt`](./FUNCIONAMENTO.txt).

> **Atenção:** o backend do marketplace (anúncios, serviços, matches, créditos, disputas e painel admin) está pronto, mas as **rotas e páginas React ainda não foram registradas** — ver status no `FUNCIONAMENTO.txt`, item 26.

## Funcionalidades

- **Autenticação** (Laravel Fortify): registro, login, logout, recuperação de senha e verificação de e-mail
- **Passkeys** (WebAuthn): login sem senha
- **Autenticação de dois fatores** (2FA/TOTP): QR Code, confirmação e códigos de recuperação
- **Roles**: videomaker / cliente / empresa / administrador
- **Localidades IBGE**: estados e municípios brasileiros
- **Anúncios de equipamento** com moderação de admin
- **Serviços de produção** (tarifa por hora/diária/permuta)
- **Matches** (permuta direta, venda ou permuta por crédito)
- **Créditos**: livro-razão com saldo derivado e transferência automática
- **Disputas** resolvidas pelo administrador
- **Assinaturas** (Stripe): trial/pro/max com bloqueio automático por inadimplência
- **Painel administrativo**: métricas, validação de cadastros e moderação
- **Painel** autenticado em `/dashboard`
- **Configurações**: perfil, segurança e aparência (tema claro/escuro/sistema)
- **SSR** do Inertia (server-side rendering)
- Equipes e convites de membros (código presente, mas **rotas desativadas** — ver `routes/settings.php`)

## Stack

| Camada   | Tecnologia |
|----------|------------|
| Backend  | PHP 8.4, Laravel 13, Laravel Fortify, Laravel Cashier 16 (Stripe), Inertia Laravel v3 |
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
php artisan db:seed            # roles, planos e admin inicial
php artisan app:import-ibge-locations   # estados e municípios do IBGE
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
| `php artisan wayfinder:generate --with-form` | Regenera tipagem de rotas do front |

## Estrutura

```
app/
  Actions/Fortify        Criação de usuário e reset de senha
  Actions/Teams          Criação de equipes
  Concerns/              HasTeams, regras de validação, slugs
  Console/Commands       Importa IBGE, promove admin, checa assinaturas
  Enums/                 UserRole, Listing*, Service/Rate, TradeType,
                         MatchStatus, CreditReason, Dispute*, Team*
  Http/Controllers       Dashboard, Settings/*, Subscription, Localidade,
                         Listing, Service, Match, Admin/*
  Http/Middleware        EnsureAdminRole, EnsureAccountNotBlocked
  Http/Requests          Anúncio, serviço, match, disputa, settings
  Listeners/             HandleStripeBillingEvents (webhook)
  Models/                User, Role, State, Municipality, Listing, Service,
                         TradeMatch, CreditTransaction, Dispute, Plan, Payment
  Services/              IbgeLocations (API de localidades)
resources/js/
  pages/                 welcome, dashboard, auth, settings, teams, assinatura
  layouts/               App, Auth, Settings
  components/            UI (shadcn) e componentes de domínio
  hooks/                 use-appearance, use-main-nav, use-flash-toast, ...
  ssr.tsx                Entry do SSR
  app.tsx                Entry do client
routes/
  web.php                Rotas públicas, assinatura, dashboard
  settings.php           Configurações (rotas de equipe comentadas)
```

## Ambiente

Configuração relevante no `.env`:

- `APP_LOCALE=pt_BR`, `APP_FALLBACK_LOCALE=pt_BR`, `APP_FAKER_LOCALE=pt_BR`
- `DB_CONNECTION=sqlite`
- `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`
- `MAIL_MAILER=log` (e-mails em `storage/logs` no dev)
- Stripe: `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET`, `STRIPE_PRICE_PRO`, `STRIPE_PRICE_MAX`, `CASHIER_CURRENCY=brl`

## Testes

```bash
php artisan test --compact
```

**Atenção:** testes de equipes (ex.: `TeamInvitationTest`, `DashboardTest::pendingInvitations`)
falham de propósito — as rotas de equipes estão desativadas em `routes/settings.php`.

## Licença

MIT — framework Laravel ([licença MIT](https://opensource.org/licenses/MIT)).
