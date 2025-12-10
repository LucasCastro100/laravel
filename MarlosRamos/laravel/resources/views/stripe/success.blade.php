<x-stripe-layout title="Pagamento Confirmado">
    <h1 class="text-green-600 text-2xl font-bold mb-3">Pagamento realizado!</h1>

    <p class="mb-4">Obrigado! Seu acesso será liberado automaticamente.</p>
    <p class="mb-4">Você recebera um email com os dados de acesso</p>

    <a href="{{ route('login') }}" class="text-indigo-600 underline">Ir ao Dashboard</a>
</x-stripe-layout>
