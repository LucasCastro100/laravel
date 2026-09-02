# Clubset — Portal do Audiovisual / Permuta

Sistema web construído com o **Laravel 13 React Starter Kit** — Inertia 3, React 19, TypeScript, Tailwind 4 e shadcn/ui. Interface fixa em **pt-BR**. Nome de fantasia: **Clubset** (também referido como "ClubTem").

Marketplace de permuta para o mercado audiovisual: anúncios de equipamento, serviços de produção, matches (interesse) para troca direta, venda ou permuta por créditos, disputas resolvidas pelo administrador e um livro-razão de **permutas** (controle de ganhos/despesas) — com assinaturas e cobrança recorrente via Stripe.

---

## 1. Como o sistema funciona

### Contas e acesso
- Cadastro, login, logout, recuperação de senha, verificação de e-mail, **passkeys** (WebAuthn) e **2FA** (TOTP) via Laravel Fortify.
- Quatro tipos de usuário (roles): **videomaker** (padrão), **cliente**, **empresa** e **administrador**.
- Cadastros de usuário só ficam "validados" quando um administrador aprova (`admin_verified_at`).

### Localização
- Estados e municípios do Brasil importados da API do IBGE com `php artisan app:import-ibge-locations`; usuários, anúncios e serviços apontam para estado/município (select dependente).

### Marketplace
1. **Anúncios de equipamento** — o usuário oferece ou procura equipamento (câmera, lente, áudio, iluminação, drone, etc.) para permuta, venda ou ambos. Anúncios novos e editados passam por **moderação do administrador** antes de ficarem públicos.
2. **Serviços** — o profissional publica um serviço (filmagem, edição, fotografia, streaming...) com tarifa por hora/diária ou permuta. Nasce ativo, sem moderação.
3. **Matches** — ao achar um anúncio/serviço, o usuário manifesta interesse (seeker → provider) escolhendo **permuta direta**, **permuta por crédito** ou **venda**, com preço negociado e mensagem. O provider aceita, recusa, ou o interessado cancela.
4. **Créditos** — permuta por crédito usa um livro-razão (ledger): ao concluir o match, o sistema transfere automaticamente os créditos do seeker para o provider (saldo insuficiente impede a conclusão).
5. **Disputas** — se algo der errado, o participante abre uma disputa e o administrador resolve ou arquiva.

### Permutas (fluxo de caixa)
- Módulo independente do mercado: o usuário lança **permutas** (com título, contato, valor, status e data) e acompanha um resumo financeiro (**ganhos**, **despesas** e **total**).
- O contato vinculado pode ser outro usuário da plataforma ou uma pessoa avulsa (nesse caso, registrado como cliente).
- Há filtros por **origem** (eu criei / me vincularam) e por **data**, além de links de **compartilhamento público** por UUID.

### Planos e cobranças
- Assinaturas **trial** (grátis) / **pro** / **max** com checkout no **Stripe** (Laravel Cashier 16).
- Webhooks processam pagamento aprovado/falho; conta em atraso há mais de 7 dias é **bloqueada automaticamente** até regularizar.

### Administração (`/admin`)
- Painel com métricas (usuários, anúncios pendentes, matches, disputas, créditos em circulação), validação de cadastros e moderação de anúncios, e configurações da plataforma.

---

## 2. Funcionalidades

- **Autenticação** (Laravel Fortify): registro, login, logout, recuperação de senha e verificação de e-mail
- **Passkeys** (WebAuthn): login sem senha
- **Autenticação de dois fatores** (2FA/TOTP): QR Code, confirmação e códigos de recuperação
- **Roles**: videomaker / cliente / empresa / administrador
- **Localidades IBGE**: estados e municípios brasileiros
- **Anúncios de equipamento** com moderação de admin
- **Serviços de produção** (tarifa por hora/diária/permuta)
- **Matches** (permuta direta, venda ou permuta por crédito)
- **Permutas** (livro-razão de ganhos/despesas com filtros e compartilhamento)
- **Créditos**: livro-razão com saldo derivado e transferência automática
- **Disputas** resolvidas pelo administrador
- **Assinaturas** (Stripe): trial/pro/max com bloqueio automático por inadimplência
- **Painel administrativo**: métricas, validação de cadastros, moderação e configurações
- **Painel** autenticado em `/dashboard`
- **Configurações**: perfil, segurança e aparência (tema escuro fixo)
- **SSR** do Inertia (server-side rendering)
- Equipes e convites de membros (código presente, mas **rotas desativadas** — ver `routes/settings.php`)

---

## 3. Stack

| Camada   | Tecnologia |
|----------|------------|
| Backend  | PHP 8.4, Laravel 13, Laravel Fortify, Laravel Cashier 16 (Stripe), Inertia Laravel v3 |
| Frontend | Inertia v3, React 19, TypeScript, Tailwind 4, shadcn/ui, Lucide, Sonner |
| Banco    | MySQL (produção) / SQLite (testes) |
| Gerenciador de pacotes | **pnpm** |
| Lint / formatação | **Biome** (substituiu ESLint + Prettier) |
| Build    | Vite, Wayfinder, React Compiler |
| Testes   | Pest |

---

## 4. Requisitos

- PHP >= 8.3 (projeto configurado para 8.4)
- Composer
- Node.js + **pnpm** (≥ 9)

---

## 5. Instalação

```bash
composer install
cp .env.example .env          # ajuste as credenciais
php artisan key:generate
php artisan migrate
php artisan db:seed            # roles, planos e admin inicial
php artisan app:import-ibge-locations   # estados e municípios do IBGE
pnpm install
pnpm approve-builds @biomejs/biome
pnpm build
```

Ou use o script do composer:

```bash
composer run setup
```

---

## 6. Desenvolvimento

```bash
composer run dev
```

Isso sobe o servidor Laravel em `http://localhost:8000` e o Vite (com SSR automático em dev).

### Scripts úteis

| Comando | Descrição |
|---------|-----------|
| `pnpm dev` | Vite em modo dev |
| `pnpm build` | Build de produção (client) |
| `pnpm build:ssr` | Build de produção + bundle SSR (`bootstrap/ssr/ssr.js`) |
| `pnpm lint` | Biome — corrige lint |
| `pnpm format` | Biome — formata e organiza imports |
| `pnpm types:check` | Checagem de tipos TypeScript (`tsc --noEmit`) |
| `vendor/bin/pint` | Formatação do código PHP |
| `php artisan test --compact` | Suíte de testes (Pest) |
| `php artisan wayfinder:generate --with-form` | Regenera tipagem de rotas do front |

---

## 7. Estrutura

```
app/
  Actions/Fortify        Criação de usuário e reset de senha
  Actions/Teams          Criação de equipes
  Concerns/              HasTeams, regras de validação, slugs
  Console/Commands       Importa IBGE, promove admin, checa assinaturas
  Enums/                 UserRole, Listing*, Service/Rate, TradeType,
                         MatchStatus, CreditReason, Dispute*, Team*
  Http/Controllers       Dashboard, Settings/*, Subscription, Localidade,
                         Listing, Service, Match, Permuta, Admin/*
  Http/Middleware        EnsureAdminRole, EnsureAccountNotBlocked, SecurityHeaders
  Http/Requests          Anúncio, serviço, match, disputa, permuta, settings
  Listeners/             HandleStripeBillingEvents (webhook)
  Models/                User, Role, State, Municipality, Listing, Service,
                         TradeMatch, CreditTransaction, Dispute, Permuta,
                         Plan, Payment
  Providers/             AppServiceProvider (rate limit, eventos)
  Services/              IbgeLocations (API de localidades)
resources/js/
  pages/                 welcome, dashboard, auth, settings, teams, assinatura,
                         listings, services, matches, permutas, admin
  layouts/               App, Auth, Settings
  components/            UI (shadcn) e componentes de domínio
  hooks/                 use-appearance, use-main-nav, use-flash-toast, ...
  ssr.tsx                Entry do SSR
  app.tsx                Entry do client
routes/
  web.php                Rotas públicas, assinatura, dashboard, marketplace
  settings.php           Configurações (rotas de equipe comentadas)
```

---

## 8. Segurança

- Senhas com **bcrypt (12 rounds)** e re-hash automático no login.
- **Cookies** de sessão encriptados com `secure`/`http_only`/`SameSite=Lax`.
- **Mass assignment** bloqueado — todos os modelos usam allowlist (`Fillable`).
- **Query parametrizada** em toda a aplicação (sem concatenação SQL).
- **Uploads** de imagens validados (image, `mimes:jpeg,jpg,png,webp`, `max:5120`).
- **Rate limiting** (30/min) nas rotas de escrita do marketplace, além de login/2FA/passkeys.
- **Security headers** globais: `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy` e HSTS (em produção).
- **Ownership checks** nas atualizações de anúncio/serviço/permuta (403 para não-donos).
- Campos sensíveis do usuário (`stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `must_change_password`) ocultos da serialização para o front.

---

## 9. Ambiente

Configuração relevante no `.env`:

- `APP_LOCALE=pt_BR`, `APP_FALLBACK_LOCALE=pt_BR`, `APP_FAKER_LOCALE=pt_BR`
- `DB_CONNECTION=mysql` (produção) / `sqlite` (testes)
- `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`
- `MAIL_MAILER=log` (e-mails em `storage/logs` no dev)
- Stripe: `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET`, `STRIPE_PRICE_PRO`, `STRIPE_PRICE_MAX`, `CASHIER_CURRENCY=brl`

---

## 10. Comandos úteis

```bash
php artisan db:seed                              # roles + planos + admin inicial
php artisan app:make-admin {email}               # torna um usuário administrador
php artisan app:import-ibge-locations            # importa estados/municípios do IBGE
php artisan subscriptions:check-overdue          # bloqueia assinaturas inadimplentes
php artisan wayfinder:generate --with-form       # gera tipagem de rotas do front
vendor/bin/pint                                  # formata o PHP
php artisan test --compact                       # roda a suíte Pest
```

Stripe CLI (dev): `stripe listen --forward-to localhost:8000/stripe/webhook`

---

## 11. Testes

```bash
php artisan test --compact
```

**Atenção:** os testes de equipes (ex.: `TeamInvitationTest`, `DashboardTest::pendingInvitations`)
falham de propósito — as rotas de equipes estão desativadas em `routes/settings.php`.
O teste de registro (`new users can register`) também falha porque o formulário exige
o campo `role`, que não é enviado no teste padrão.

---

## 12. Pontos de atenção

- Rotas de equipes **desativadas a pedido** (`routes/settings.php`).
- Convites pendentes no dashboard desativados (`DashboardController`).
- Interface **100% pt-BR fixo** (i18n removido).
- Usa **React Compiler** — cuidado com memoização ao mexer em componentes.
- **Não alterar dependências sem aprovação**; seguir as convenções do projeto.
- Créditos usam ledger (sem coluna de saldo no `users`): sempre derivar o saldo com `User::availableBalance()`.
- Transferência de crédito (`MatchController::complete`) roda dentro de `DB::transaction`, verificando saldo antes do débito.
- Moderação: anúncio editado volta para "pending" (republicação exige nova aprovação); serviços não passam por moderação.
- Banco de produção (MySQL de hospedagem) tem limite de **conexões por hora** (`max_connections_per_hour`) — erros 500 intermitentes em tela vêm desse limite, não de bugs.

---

## Licença

MIT — framework Laravel ([licença MIT](https://opensource.org/licenses/MIT)).
