---
paths:
  - 'resources/js/routes/**'
---

# Routes

## Wayfinder: sempre regenerar com --with-form
Rodar `php artisan wayfinder:generate --with-form --no-interaction`. A geração sem --with-form quebra os helpers `.form()` usados pelas páginas de formulário existentes. Em dev o plugin Vite regenera automaticamente.
