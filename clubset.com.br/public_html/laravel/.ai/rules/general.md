---
paths:
  - '**'
---

# General

## Ignore pull on sistema-robson, force push local
When a git pull is needed for this project, always ignore the remote changes and force push (--force) the local state instead. Never merge or rebase remote commits.

## Use pnpm, never npm, for JS commands
This project uses pnpm (pnpm-lock.yaml). All frontend commands must be run with pnpm (pnpm run build, pnpm run dev, pnpm install). Never use npm.

## Hostinger: web root é public_html; assets estáticos precisam estar na raiz
Deploy Hostinger: o web root é o public_html (index.php lá roda o Laravel com usePublicPath(__DIR__); storage real fica em public_html/storage). TODO asset estático referenciado por URL absoluta (img, build, favicon.ico, robots.txt) precisa existir na RAIZ public_html — via symlink para laravel/public/... (padrão já usado no build) ou cópia real via FTP. Arquivos só dentro de laravel/public NÃO são servidos em /img, /build etc.
