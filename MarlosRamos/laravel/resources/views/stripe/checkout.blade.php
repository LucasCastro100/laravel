<x-stripe-layout title="Finalizar Pagamento">

    <h1 class="text-xl font-bold mb-4">Finalizar Pagamento</h1>

    <div class="bg-white shadow rounded p-4 mb-6 flex flex-row gap-4 items-center justify-center">
        <img src="{{ $course->image_url }}" class="w-24 h-24 object-cover rounded">
        <div>
            <h2 class="text-lg font-semibold">{{ $course->title }}</h2>
            <p class="text-gray-700">
                R$ {{ number_format($course->price_in_cents / 100, 2, ',', '.') }}
            </p>
        </div>
    </div>

    <form id="payment-form">
        @csrf

        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <input type="hidden" id="amount" value="{{ $course->price_in_cents }}">

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

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        let elements;

        async function setupPaymentElement() {
            try {
                const response = await fetch("{{ route('stripe.paymentIntent') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        course_id: "{{ $course->id }}",
                        name: document.getElementById("buyer_name").value,
                        email: document.getElementById("buyer_email").value
                    })
                });

                const data = await response.json();

                const appearance = { theme: 'stripe' };
                elements = stripe.elements({ clientSecret: data.clientSecret, appearance });

                const paymentElement = elements.create("payment");
                paymentElement.mount("#payment-element");

                // Habilita o botão
                document.getElementById("submit").disabled = false;
            } catch (err) {
                console.error("Erro ao criar PaymentIntent:", err);
                alert("Não foi possível iniciar o pagamento. Tente novamente.");
            }
        }

        setupPaymentElement();

        document.getElementById("payment-form").addEventListener("submit", async (e) => {
            e.preventDefault();

            if (!elements) {
                alert("Os elementos de pagamento ainda não estão prontos!");
                return;
            }

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "{{ route('payment.success') }}",
                },
            });

            if (error) {
                alert(error.message);
            }
        });
    </script>

</x-stripe-layout>
