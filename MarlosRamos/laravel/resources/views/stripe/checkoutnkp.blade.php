<x-stripe-layout title="Finalizar Pagamento">

    <h1 class="text-xl font-bold mb-4">Finalizar Pagamento</h1>

    <div class="bg-white shadow rounded p-4 mb-6 flex flex-row gap-4 items-center justify-center">
        <img src="{{ $course->image_url }}" class="w-24 h-24 object-cover rounded">
        <div>
            <h2 class="text-lg font-semibold">{{ $course->title }}</h2>
            <p class="text-gray-700">
                R$ {{ number_format($course->price / 100, 2, ',', '.') }}
            </p>
        </div>
    </div>

    <form id="payment-form">
        @csrf

        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <input type="hidden" id="amount" value="{{ $course->price }}">

        @guest
            <label class="font-medium">Nome</label>
            <input type="text" id="buyer_name" required class="border rounded w-full mb-3 px-3 py-2">

            <label class="font-medium">Email</label>
            <input type="email" id="buyer_email" required class="border rounded w-full mb-4 px-3 py-2">
        @else
            <input type="hidden" id="buyer_name" value="{{ Auth::user()->name }}">
            <input type="hidden" id="buyer_email" value="{{ Auth::user()->email }}">
        @endguest

        <div id="payment-element" class="my-4"></div>

        <button id="submit" class="mt-4 w-full bg-indigo-600 text-white py-3 rounded" disabled>
            Pagar agora
        </button>
    </form>    

    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
    
        const btn = document.getElementById("checkout-button");
        btn.addEventListener("click", async () => {
            const response = await fetch("{{ route('checkout.create', $course->uuid) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
            });
            const session = await response.json();
            stripe.redirectToCheckout({ sessionId: session.id });
        });
</script>
</x-stripe-layout>
