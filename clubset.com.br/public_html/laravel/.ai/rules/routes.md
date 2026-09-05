---
paths:
  - 'resources/js/routes/**'
---

# Routes

## Wayfinder: sempre regenerar com --with-form
Rodar `php artisan wayfinder:generate --with-form --no-interaction`. A geração sem --with-form quebra os helpers `.form()` usados pelas páginas de formulário existentes. Em dev o plugin Vite regenera automaticamente.

## wayfinder:generate exige --with-form para gerar .form()
Sempre gerar com `php artisan wayfinder:generate --with-form` (o plugin wayfinder do vite.config usa formVariants: true). Rodar sem --with-form regrava os arquivos SEM os variantes .form() e quebra todos os <Form {...x.form()}> (registrations, moderation, etc.) com erro TS 'Property form does not exist'.
