# Plano de Migração: MarlosRamos → Laravel 13 + React + Inertia

> **Objetivo:** Recriar o sistema MarlosRamos (plataforma EAD/LMS) usando a arquitetura do clubset.com.br (Laravel 13 + React + Inertia v3 + TypeScript + shadcn/ui + Wayfinder), com estrutura `public_html/laravel/` para deploy na Hostinger.

---

## 📁 Estrutura de Pastas Final

```
public_html/
├── .htaccess
└── laravel/
    ├── app/
    │   ├── Console/Commands/
    │   │   ├── CheckCron.php
    │   │   ├── ClearCach.php
    │   │   └── MakeAdmin.php
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── Dashboard/
    │   │   │   │   ├── AdminController.php
    │   │   │   │   ├── StudentController.php
    │   │   │   │   └── TeacherController.php
    │   │   │   ├── Courses/CourseController.php
    │   │   │   ├── Modules/ModuleController.php
    │   │   │   ├── Classrooms/ClassroomController.php
    │   │   │   ├── Tests/TestController.php
    │   │   │   ├── Matriculations/MatriculationController.php
    │   │   │   ├── Certificates/CertificateController.php
    │   │   │   ├── Comments/
    │   │   │   │   ├── CommentController.php
    │   │   │   │   └── CommentReplyController.php
    │   │   │   ├── Assessments/AssessmentController.php
    │   │   │   ├── Contacts/
    │   │   │   │   ├── ContactController.php
    │   │   │   │   └── ContactReplyController.php
    │   │   │   ├── Stripe/StripeController.php
    │   │   │   ├── Settings/
    │   │   │   │   ├── ProfileController.php
    │   │   │   │   └── PasswordController.php
    │   │   │   └── Controller.php
    │   │   ├── Middleware/
    │   │   │   ├── EnsureRoleMiddleware.php
    │   │   │   └── HandleInertiaRequests.php
    │   │   └── Requests/
    │   ├── Mail/
    │   │   ├── AccessGrantedMail.php
    │   │   └── CoursePurchasedMail.php
    │   ├── Models/
    │   │   ├── User.php
    │   │   ├── Role.php
    │   │   ├── Student.php
    │   │   ├── Teacher.php
    │   │   ├── Course.php
    │   │   ├── Module.php
    │   │   ├── Classroom.php
    │   │   ├── ClassroomUser.php
    │   │   ├── Test.php
    │   │   ├── MatriculationCourse.php
    │   │   ├── MatriculationTest.php
    │   │   ├── Comment.php
    │   │   ├── CommentReply.php
    │   │   ├── Assessment.php
    │   │   ├── Payment.php
    │   │   ├── Contact.php
    │   │   ├── ContactReply.php
    │   │   └── TesteRepresentacional.php
    │   ├── Providers/
    │   │   └── AppServiceProvider.php
    │   ├── Services/
    │   │   ├── YoutubeService.php
    │   │   └── PdfService.php
    │   └── View/Components/
    │       └── AppLayout.php
    ├── config/
    ├── database/
    │   ├── migrations/
    │   └── seeders/
    │       ├── DatabaseSeeder.php
    │       ├── RoleSeeder.php
    │       ├── UserSeeder.php
    │       ├── CourseSeeder.php
    │       ├── ModuleSeeder.php
    │       ├── ClassroomSeeder.php
    │       ├── MatriculationCourseSeeder.php
    │       ├── TestSeeder.php
    │       └── CommentSeeder.php
    ├── public/
    │   ├── build/
    │   └── index.php
    ├── resources/
    │   ├── css/app.css
    │   └── js/
    │       ├── app.tsx
    │       ├── bootstrap.ts
    │       ├── components/ui/
    │       ├── layouts/
    │       │   ├── app-layout.tsx
    │       │   └── auth-layout.tsx
    │       ├── lib/utils.ts
    │       ├── pages/
    │       │   ├── welcome.tsx
    │       │   ├── auth/
    │       │   ├── dashboard/
    │       │   ├── courses/
    │       │   ├── modules/
    │       │   ├── classrooms/
    │       │   ├── tests/
    │       │   ├── certificates/
    │       │   ├── settings/
    │       │   └── stripe/
    │       └── types/index.d.ts
    ├── routes/
    │   └── web.php
    ├── scripts/
    │   ├── deploy.sh
    │   ├── clear-cache.sh
    │   ├── rebuild.sh
    │   └── update.sh
    ├── storage/
    ├── .env
    ├── .gitignore
    ├── artisan
    ├── composer.json
    ├── package.json
    └── vite.config.ts
```

---

## 📋 Checklist de Implementação

### Fase 1: Setup do Projeto
- [x] Criar pasta `public_html/laravel/`
- [x] Instalar Laravel 13 via Composer
- [x] Configurar `.htaccess` na raiz `public_html/`
- [x] Instalar Inertia.js v3 + React + TypeScript
- [x] Instalar Wayfinder (`laravel/wayfinder`)
- [x] Instalar shadcn/ui + Tailwind CSS 4
- [x] Configurar `vite.config.ts` para React
- [x] Configurar `tsconfig.json`
- [x] Criar estrutura de pastas (pages, components, layouts, etc.)
- [ ] Configurar SSR (`resources/js/ssr.tsx`)

### Fase 2: Database & Models
- [x] Criar Migration: `roles`
- [x] Criar Migration: `students`
- [x] Criar Migration: `teachers`
- [x] Criar Migration: `courses`
- [x] Criar Migration: `modules`
- [x] Criar Migration: `classrooms`
- [x] Criar Migration: `classroom_user`
- [x] Criar Migration: `tests`
- [x] Criar Migration: `matriculation_courses`
- [x] Criar Migration: `matriculation_tests`
- [x] Criar Migration: `comments`
- [x] Criar Migration: `comment_replies`
- [x] Criar Migration: `assessments`
- [x] Criar Migration: `payments`
- [x] Criar Migration: `contacts`
- [x] Criar Migration: `contact_replies`
- [x] Criar Migration: `teste_representacionals`
- [x] Criar Model: `User.php` (com relationships)
- [x] Criar Model: `Role.php`
- [x] Criar Model: `Student.php`
- [x] Criar Model: `Teacher.php`
- [x] Criar Model: `Course.php`
- [x] Criar Model: `Module.php`
- [x] Criar Model: `Classroom.php`
- [x] Criar Model: `ClassroomUser.php`
- [x] Criar Model: `Test.php`
- [x] Criar Model: `MatriculationCourse.php`
- [x] Criar Model: `MatriculationTest.php`
- [x] Criar Model: `Comment.php`
- [x] Criar Model: `CommentReply.php`
- [x] Criar Model: `Assessment.php`
- [x] Criar Model: `Payment.php`
- [x] Criar Model: `Contact.php`
- [x] Criar Model: `ContactReply.php`
- [x] Criar Model: `TesteRepresentacional.php`
- [x] Criar Seeders:
  - [x] `RoleSeeder.php` (Aluno=1, Professor=2, Administrador=3)
  - [x] `UserSeeder.php` (admin, professor, aluno)
  - [x] `CourseSeeder.php`
  - [x] `ModuleSeeder.php`
  - [x] `ClassroomSeeder.php`
  - [x] `MatriculationCourseSeeder.php`
  - [x] `TestSeeder.php`
  - [x] `CommentSeeder.php`
  - [x] `DatabaseSeeder.php` (chama todos os seeders)
- [x] Rodar `php artisan migrate`

### Fase 3: Auth & Middleware
- [x] Configurar `HandleInertiaRequests.php` middleware
- [x] Criar `EnsureRoleMiddleware.php` (role:1,2,3)
- [x] Registrar middlewares em `bootstrap/app.php`

### Fase 4: Controllers - Dashboard
- [x] Criar `Dashboard/AdminController.php`
  - [x] Métricas: total cursos, alunos, professores, matrículas
  - [x] Listar últimos usuários
  - [ ] Listar últimos pagamentos
- [x] Criar `Dashboard/StudentController.php`
  - [x] Meus cursos
  - [x] Meus testes
  - [ ] Certificados
  - [x] Progresso geral
- [x] Criar `Dashboard/TeacherController.php`
  - [x] Cursos criados
  - [x] Total de alunos
  - [x] Últimos comentários
  - [ ] Últimas matrículas

### Fase 5: Controllers - Cursos
- [x] Criar `Courses/CourseController.php`
  - [x] `index()` - Listar cursos (professor: seus cursos, admin: todos)
  - [x] `create()` - Formulário de criação
  - [x] `store()` - Salvar curso (CourseRequest)
  - [x] `show()` - Detalhes do curso
  - [x] `edit()` - Formulário de edição
  - [x] `update()` - Atualizar curso
  - [x] `destroy()` - Deletar curso
  - [x] `myCourses()` - Cursos do aluno matriculado

### Fase 6: Controllers - Módulos
- [x] Criar `Modules/ModuleController.php`
  - [x] `index()` - Listar módulos do curso
  - [x] `create()` - Formulário de criação
  - [x] `store()` - Salvar módulo
  - [x] `edit()` - Formulário de edição
  - [x] `update()` - Atualizar módulo
  - [x] `destroy()` - Deletar módulo

### Fase 7: Controllers - Salas de Aula
- [x] Criar `Classrooms/ClassroomController.php`
  - [x] `index()` - Listar aulas do módulo
  - [x] `create()` - Formulário de criação
  - [x] `store()` - Salvar aula (com vídeo YouTube)
  - [x] `show()` - Assistir aula (com player)
  - [x] `edit()` - Formulário de edição
  - [x] `update()` - Atualizar aula
  - [x] `destroy()` - Deletar aula
  - [x] `complete()` - Marcar aula como concluída

### Fase 8: Controllers - Testes
- [x] Criar `Tests/TestController.php`
  - [x] `index()` - Listar testes
  - [x] `create()` - Formulário de criação
  - [x] `store()` - Salvar teste (com perguntas JSON)
  - [x] `show()` - Detalhes do teste
  - [x] `take()` - Responder teste
  - [x] `submit()` - Enviar respostas e calcular nota
  - [x] `edit()` - Formulário de edição
  - [x] `update()` - Atualizar teste
  - [x] `destroy()` - Deletar teste

### Fase 9: Controllers - Matrículas
- [x] Criar `Matriculations/MatriculationController.php`
  - [x] `enroll()` - Matricular aluno no curso
  - [x] `myEnrollments()` - Listar matrículas do aluno
  - [x] `verify()` - Verificar se está matriculado

### Fase 10: Controllers - Certificados
- [x] Criar `Certificates/CertificateController.php`
  - [x] `generate()` - Gerar PDF do certificado
  - [x] `download()` - Download do certificado
- [x] Criar `Services/PdfService.php` (DomPDF)

### Fase 11: Controllers - Comentários
- [x] Criar `Comments/CommentController.php`
  - [x] `store()` - Criar comentário
  - [x] `update()` - Editar comentário
  - [x] `destroy()` - Deletar comentário
- [x] Criar `Comments/CommentReplyController.php`
  - [x] `store()` - Criar resposta
  - [x] `update()` - Editar resposta
  - [x] `destroy()` - Deletar resposta

### Fase 12: Controllers - Assessments
- [x] Criar `Assessments/AssessmentController.php`
  - [x] `store()` - Criar avaliação (nota)
  - [x] `update()` - Atualizar avaliação
  - [x] `destroy()` - Deletar avaliação

### Fase 13: Controllers - Contatos
- [x] Criar `Contacts/ContactController.php`
  - [x] `store()` - Enviar dúvida
  - [x] `index()` - Listar contatos (professor)
  - [x] `show()` - Detalhes do contato
- [x] Criar `Contacts/ContactReplyController.php`
  - [x] `store()` - Responder contato

### Fase 14: Controllers - Stripe
- [x] Criar `Stripe/StripeController.php`
  - [x] `checkout()` - Criar sessão de checkout
  - [x] `success()` - Página de sucesso
  - [x] `cancel()` - Página de cancelamento
  - [ ] `webhook()` - Webhook do Stripe
  - [ ] Configurar Stripe no `.env`

### Fase 15: Controllers - Settings
- [x] Criar `Settings/ProfileController.php`
  - [x] `edit()` - Formulário de perfil
  - [x] `update()` - Atualizar perfil
- [x] Criar `Settings/PasswordController.php`
  - [x] `edit()` - Formulário de senha
  - [x] `update()` - Atualizar senha

### Fase 16: Rotas
- [x] Criar `routes/web.php`
  - [x] Rotas públicas (welcome, stripe checkout)
  - [x] Rotas autenticadas (dashboard, settings)
  - [x] Rotas student (`/painel-aluno`)
  - [x] Rotas teacher (`/painel-professor`)
  - [x] Rotas admin (`/painel-admin`)

### Fase 17: Frontend - Layouts
- [x] Criar `layouts/app-layout.tsx` (com sidebar)
- [x] Criar `layouts/auth-layout.tsx`

### Fase 18: Frontend - Auth Pages
- [x] Criar `pages/auth/login.tsx`
- [x] Criar `pages/auth/register.tsx`
- [ ] Criar `pages/auth/forgot-password.tsx`
- [ ] Criar `pages/auth/reset-password.tsx`
- [ ] Criar `pages/auth/verify-email.tsx`
- [ ] Criar `pages/auth/confirm-password.tsx`

### Fase 19: Frontend - Dashboard Pages
- [x] Criar `pages/dashboard.tsx` (redirect por role)
- [x] Criar `pages/dashboard/admin/index.tsx`
  - [x] Métricas com cards
  - [x] Tabela de usuários
- [x] Criar `pages/dashboard/student/index.tsx`
  - [x] Meus cursos
  - [x] Progresso
- [x] Criar `pages/dashboard/teacher/index.tsx`
  - [x] Meus cursos
  - [x] Alunos
  - [x] Comentários recentes

### Fase 20: Frontend - Course Pages
- [x] Criar `pages/courses/index.tsx`
  - [x] Grid de cursos
  - [x] Paginação
- [x] Criar `pages/courses/show.tsx`
  - [x] Info do curso
  - [x] Lista de módulos
  - [x] Botão de matrícula/compra
- [x] Criar `pages/courses/form.tsx`
  - [x] Formulário criar/editar
  - [x] Configurações de certificado
- [x] Criar `pages/courses/student-courses.tsx`
  - [x] Cursos matriculados com progresso

### Fase 21: Frontend - Module Pages
- [x] Criar `pages/modules/index.tsx`

### Fase 22: Frontend - Classroom Pages
- [x] Criar `pages/classrooms/index.tsx`
  - [x] Lista de aulas do módulo
- [x] Criar `pages/classrooms/show.tsx`
  - [x] Player de vídeo YouTube
  - [x] Conteúdo da aula
  - [x] Comentários
  - [x] Avaliações
  - [x] Botão concluir

### Fase 23: Frontend - Test Pages
- [x] Criar `pages/tests/index.tsx`
- [x] Criar `pages/tests/show.tsx`

### Fase 24: Frontend - Certificate Pages
- [x] Criar `pages/certificates/index.tsx`
  - [x] Lista de certificados
  - [x] Botão download PDF

### Fase 26: Frontend - Settings Pages
- [x] Criar `pages/settings/profile.tsx`
- [x] Criar `pages/settings/password.tsx`

### Fase 27: Frontend - Stripe Pages
- [x] Criar `pages/stripe/checkout.tsx`
- [x] Criar `pages/stripe/success.tsx`
- [x] Criar `pages/stripe/cancel.tsx`

### Fase 28: Serviços
- [x] Criar `Services/YoutubeService.php`
  - [x] Buscar duração do vídeo
  - [x] Extrair ID do vídeo
- [x] Criar `Services/PdfService.php`
  - [x] Gerar certificado PDF (DomPDF)
  - [x] Template do certificado

### Fase 29: Mail
- [x] Criar `Mail/AccessGrantedMail.php`
- [x] Criar `Mail/CoursePurchasedMail.php`
- [x] Criar templates de email

### Fase 30: Commands Artisan
- [x] Criar `Commands/CheckCron.php`
- [x] Criar `Commands/ClearCach.php`
- [x] Criar `Commands/MakeAdmin.php`

### Fase 31: Configurações Finais
- [ ] Configurar `.env` (database, Stripe, YouTube, mail)
- [ ] Configurar `config/services.php` (Stripe keys)
- [ ] Configurar `config/questionsTest.php`
- [ ] Configurar `config/relatorios.php`

### Fase 32: Deploy Hostinger
- [x] Configurar `.htaccess` raiz (`public_html/`)
- [x] Configurar `.htaccess` (`public_html/laravel/public/`)
- [x] Criar scripts SSH (`deploy.sh`, `clear-cache.sh`, `rebuild.sh`, `update.sh`)
- [ ] Configurar `.env` na Hostinger
- [ ] Rodar `composer install --no-dev`
- [ ] Rodar `php artisan migrate --seed --force`
- [ ] Rodar `php artisan config:cache`
- [ ] Rodar `php artisan route:cache`
- [ ] Verificar permissões (`storage/`, `bootstrap/cache/`)

---

## 📊 Resumo de Diferenças (MarlosRamos → ReactNew)

### Models
- `HasUuids` e `HasFactory` removidos → UUID via `\Str::uuid()` nos seeders
- Relationship names padronizados (singular: `classroom()`, `user()`)
- Novas relationships: `Course.user()`, `Course.payments()`, `User.payments()`
- `User.courses()` mudou de `belongsToMany` para `hasMany` (professor owns courses)

### Migrations
- Todas as ALTER migrations consolidadas nas migrations de criação
- `role_id` já vem na tabela `users`
- `image_cover`/`image_banner` já vem na tabela `courses`
- `certificate_background`, `certificate_enabled` já vem na tabela `courses`
- `description` nullable na tabela `modules`

### Seeders
- Todos os 8 seeders portados com UUID
- `TesteRepresentacionalEventosSeeder` removido (13 registros antigos)
- `DatabaseSeeder` chama todos os seeders em ordem

---

## 🔧 Comandos Úteis

```bash
# Deploy completo
cd ~/public_html/laravel/scripts
./deploy.sh

# Migrate + Seed
php artisan migrate --seed --force

# Limpar cache
./clear-cache.sh

# Refazer tudo
./rebuild.sh

# Atualizar
./update.sh
```

---

## 🐛 Troubleshooting

| Problema | Solução |
|---|---|
| `Access denied` MySQL | Verificar credenciais no `.env` e IP permitido no Hostinger |
| `!` ou `:` na senha DB | Usar aspas: `DB_PASSWORD='senha!com:especiais'` |
| Rotas não encontram | Verificar `routes/web.php` e Inertia middleware |
| Componentes React não renderizam | Verificar `HandleInertiaRequests.php` |
| CSRF token error | Verificar `bootstrap.ts` com axios |
| Upload falha | Verificar `php.ini` (upload_max_filesize) |
| PDF não gera | Verificar DomPDF e permissões |
| YouTube API error | Verificar API key no `.env` |
