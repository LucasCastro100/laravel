---
paths:
  - 'app/Http/Middleware/**'
---

# Middleware

## Usuário pendente (não verificado) só acessa o próprio perfil
Cadastro novo fica com admin_verified_at null até o admin aceitar em /admin/cadastros. EnsureUserIsVerified redireciona usuário não-admin não-verificado para profile.edit em tudo (dashboard, listings, services, matches, permutas, assinatura, primeiro-acesso, settings). Rotas livres: profile.edit, profile.update, logout. Admins e usuarios com admin_verified_at passam. Tests que criam usuário com acesso pleno precisam de User::factory()->adminVerified().
