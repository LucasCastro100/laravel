# MEMÓRIA DO PROJETO - ESTRUTURA E HISTÓRICO

## VISÃO GERAL DO SISTEMA
- **Framework:** Laravel (rodando em public_html/laravel/)
- **Foco:** Performance, segurança e componentização de layout
- **Paths importantes:**
  - Código Laravel: `public_html/laravel/`
  - Config opencode: `public_html/.opencode/`
  - Views: `public_html/laravel/resources/views/`
  - Controllers: `public_html/laravel/app/Http/Controllers/`

## COMPONENTES BLADE (resources/views/components/)
- `action-button.blade.php` - Botão de ação genérico
- `alert-component.blade.php` - Componente de alerta/notificação
- `application-logo.blade.php` - Logo da aplicação
- `aside.blade.php` - Sidebar/lateral do dashboard
- `auth-session-status.blade.php` - Status de sessão de autenticação
- `course-banner.blade.php` - Banner de curso
- `course-card.blade.php` - Card de exibição de curso
- `danger-button.blade.php` - Botão de ação destrutiva (vermelho)
- `dropdown.blade.php` - Dropdown genérico
- `dropdown-link.blade.php` - Link dentro de dropdown
- `empty-state.blade.php` - Estado vazio (nenhum registro)
- `input-error.blade.php` - Mensagem de erro de input
- `input-label.blade.php` - Label de formulário
- `modal.blade.php` - Modal genérico
- `modal-panel.blade.php` - Painel do modal
- `nav-link.blade.php` - Link de navegação
- `page-title.blade.php` - Título de página
- `primary-button.blade.php` - Botão primário (azul)
- `responsive-nav-link.blade.php` - Link de navegação responsivo
- `secondary-button.blade.php` - Botão secundário
- `stat-card.blade.php` - Card de estatística/métrica
- `text-input.blade.php` - Input de texto
- `web-layout.blade.php` - Layout da landing page/pública

## LAYOUTS (resources/views/layouts/)
- `app.blade.php` - Layout principal do dashboard
- `guest.blade.php` - Layout para visitantes
- `navigation.blade.php` - Navegação principal
- `stripe.blade.php` - Layout de checkout Stripe
- `web.blade.php` - Layout público

## CONTROLLERS
### Auth
- `ConfirmablePasswordController.php` - Confirmação de senha
- `AuthenticatedSessionController.php` - Login/sessão
- `EmailVerificationNotificationController.php` - Reenvio de verificação
- `EmailVerificationPromptController.php` - Prompt de verificação
- `NewPasswordController.php` - Criação de nova senha (reset)
- `PasswordController.php` - Atualização de senha
- `PasswordResetLinkController.php` - Geração de link de reset
- `RegisteredUserController.php` - Registro de novo usuário
- `VerifyEmailController.php` - Verificação de email

### Dashboard
- `AdminController.php` - Painel administrativo (CRUD de users, config)
- `AssessmentController.php` - Avaliações de alunos
- `CertificateController.php` - Geração de certificados (PDF)
- `ClassroomController.php` - Aulas (CRUD + complete)
- `CommentController.php` - Comentários em aulas
- `CommentReplyController.php` - Respostas a comentários
- `ContactController.php` - Dúvidas/contato
- `CourseController.php` - Cursos (CRUD + upload de imagens)
- `HomeController.php` - Home do dashboard
- `MatriculationCourseController.php` - Matrícula em cursos
- `MatriculationTestController.php` - Matrícula em testes
- `ModuleController.php` - Módulos de cursos (CRUD)
- `ProfileController.php` - Perfil do usuário (edit/delete + upload avatar)
- `RoleController.php` - Gerenciamento de papéis
- `StudentController.php` - Alunos (CRUD pelo professor)
- `TeacherController.php` - Professor (dashboard + CRUD de alunos)
- `TestController.php` - Testes/avaliações (CRUD)

### Web
- `HomeController.php` - Landing page pública
- `TesteRepresentacionalController.php` - Teste representacional (Flux尔)

### Root
- `StripeController.php` - Checkout e webhooks Stripe
- `StripeControllerBkp.php` - Backup do controller Stripe (legado)
- `StripeControllerBkp2.php` - Backup 2 do controller Stripe (legado)

## MODELOS PRINCIPAIS
- User, Course, Module, Classroom, Test, Comment, CommentReply, Matriculation, Assessment, Certificate, Contact

## POLICIES
- `CoursePolicy.php` - Controle de acesso a courses (owner/admin)

## FORM REQUESTS
- `CourseRequest.php` - Validação de cursos (image|mimes:jpeg,png,jpg,gif,webp|max:4096/5120)
- `ProfileUpdateRequest.php` - Validação de perfil (corrigido typo iamge→image, mimes:jpeg,png,jpg,webp)
- `LoginRequest.php` - Validação de login

## AUDITORIAS E CORREÇÕES DE SEGURANÇA

### [09/09/2026] Auditoria inicial + correções aplicadas

**Problemas encontrados e corrigidos:**

1. **IDOR (Crítico)** → Criado `app/Policies/CoursePolicy.php`
   - `view()`: autoriza owner ou admin (role_id=3)
   - `update()`: autoriza owner ou admin
   - `delete()`: autoriza owner ou admin
   - `create()`: autoriza teacher (role_id=2) ou admin
   - Aplicado `$this->authorize()` em CourseController: `create`, `view`, `update` (edit+update), `delete`

2. **UPLOADS - hashName (Alto)** → Corrigido em CourseController e ProfileController
   - Substituído `getClientOriginalExtension()` + `uniqid()` por `$file->hashName()`
   - CourseController: `uploadImage()` agora usa hashName
   - ProfileController: upload de avatar agora usa hashName + cria diretório se necessário

3. **THROTTLE (Médio)** → Adicionado `throttle:60,1` em routes/web.php
   - Rotas de teste representacional (GET/POST) protegidas
   - Rotas de checkout Stripe (GET/POST) protegidas

4. **ProfileUpdateRequest - BUG (Crítico)** → Corrigido typo `'iamge'` → `'image'`
   - A validação de imagem nunca funcionou por causa do typo
   - Atualizado mimes: `jpeg,png,jpg,webp` (removido svg/gif)

### [09/09/2026] Re-auditoria pós-correções
- INPUT: ✅ FormRequests + $request->validate() (sem $request->all() em writes)
- IDOR: ✅ CoursePolicy criada + authorize() aplicado
- UPLOADS: ✅ hashName() em todos os uploads
- THROTTLE: ✅ throttle:60,1 nas rotas públicas
- INJECTION/XSS: ✅ Sem DB::raw() com variáveis, {!! !!} apenas em vendor/mail
- ENV: ✅ Secrets via env(), nenhum hardcoded

### Notas de infraestrutura
- Arquivos salvos em `public_path('storage/...')` (shared hosting, sem S3) - não é vulnerabilidade
- Laravel 11: Policies auto-discoveradas (sem AuthServiceProvider)
- Provedores: apenas AppServiceProvider

## AMBIENTE LOCAL (09/09/2026)
### Configuração multi-env
- `.env` → ambiente ativo (atualmente: LOCAL)
- `.env.local` → config para dev local (SQLite, debug on, http://127.0.0.1:8000)
- `.env.production` → config de produção (MySQL Hostinger, https://neurocomunicacaobrasil.com.br)
- `env-switch.sh` → script para alternar: `./env-switch.sh local` ou `./env-switch.sh production`
- `.ftpignore` → arquivos que NUNCA devem ir pro FTP (.env*, env-switch.sh, database.sqlite, tests/)
- Todos os `.env*`, `env-switch.sh`, `.ftpignore` estão no `.gitignore`
- Backup de produção ANTES da troca salvo em `.env.backup`

### DB local
- `database/database.sqlite` → banco SQLite local (criado e populado com migrate:fresh --seed)
- Seeds compatíveis com SQLite (RoleSeeder, UserSeeder, TesteRepresentacionalEventosSeeder, TesteSeeder, CourseSeeder, ModuloSeeder, ClassroomSeeder, MatriculationCourseSeeder, CommentSeeder)
- Usuários seed: administrador@gmail.com / marlosramos@yahoo.com.br / estudante@gmail.com (senha: mudar123)

### Fixes necessários para rodar local
- `app/Http/Controllers/Controller.php` → adicionado trait `AuthorizesRequests` (sem ele, `$this->authorize()` dava "undefined method")
- `vite.config.js` → adicionado `server: { https: false }` (erro "Unsupported SSL request" do Vite)

### Comandos úteis
- `php artisan serve` → iniciar servidor local
- `php artisan migrate:fresh --seed` → recriar banco local
- `npm run dev` → iniciar Vite
- `php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear` → limpar caches

## REGRAS DE FTP/DEPLOY (09/09/2026)

### 🚫 NUNCA subir para o FTP (só local)
- `.env` (ativo é LOCAL - subir quebra produção; servidor tem o .env próprio)
- `.env.production` (contém senha do DB remoto; substituiria o .env real no servidor)
- `.env.local`
- `env-switch.sh`
- `.ftpignore`
- `database/database.sqlite`
- `tests/`, `phpunit.xml`
- `node_modules/`
- `storage/` e `public/storage/` → NÃO sobrescrever (uploads reais, logs, sessões, cache do servidor)

### ✅ Pode subir
- `app/`, `bootstrap/`, `config/`, `routes/`, `resources/`
- `database/` (exceto database.sqlite)
- `public/build` (build compilado do Vite)
- `composer.json`, `composer.lock`, `artisan`, `vendor/`

### ⚠️ Regra de ouro
- O `.env` de produção é gerenciado pelo servidor. Nunca subir `.env*` locais por cima.
