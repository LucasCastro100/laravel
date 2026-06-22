@component('mail::message')
# Olá {{ $user->name }}!

A compra do curso **{{ $course->title }}** foi confirmada com sucesso! 🎉

Seu acesso já está liberado na plataforma.

@component('mail::button', ['url' => route('login')])
Acessar Plataforma
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
