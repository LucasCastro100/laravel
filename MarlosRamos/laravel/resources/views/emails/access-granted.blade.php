@component('mail::message')
# Bem-vindo(a) {{ $user->name }}!

Seu acesso ao curso **{{ $course->title }}** foi liberado com sucesso! 🎉

## Dados de acesso

- **Email:** {{ $user->email }}
- **Senha:** {{ $password }}

@component('mail::button', ['url' => route('login')])
Acessar Plataforma
@endcomponent

Se desejar, você pode alterar sua senha depois no painel do aluno.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
