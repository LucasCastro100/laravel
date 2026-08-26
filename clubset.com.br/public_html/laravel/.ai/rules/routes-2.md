---
paths:
  - routes/web.php
---

# Routes 2

## Dashboard sem prefixo de time
Times não são usados no sistema. A rota dashboard é GET /dashboard (sem {current_team}). A config de times (models, middleware, rotas comentadas em settings.php) permanece intacta para uso futuro, mas não deve ser aplicada a rotas ativas. Usuários sem time devem conseguir logar e acessar /dashboard.
