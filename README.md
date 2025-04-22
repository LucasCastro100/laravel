- PASSOS COM JETSTREAM COM LIVEWIRE
-- composer create-project laravel/laravel example-app
-- cd example-app
-- composer require laravel/jetstream
-- php artisan jetstream:install -> aqui adicionamos as config que queremos (livewire | api,dark,verification,teams | pest)


- FINALIZANDO A ISNTALAÇÃO
-- npm install
-- npm run build
-- php artisan migrate:refresh 

- PARA ATIVAR FOTO 
-- config -> jetstream -> features -> descomente fotos