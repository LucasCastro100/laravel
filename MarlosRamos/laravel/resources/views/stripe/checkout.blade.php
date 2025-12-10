<x-stripe-layout title="Finalizar Pagamento">

    <h1 class="text-xl font-bold mb-4">Finalizar Pagamento</h1>

    <div class="bg-white shadow rounded p-4 mb-6 flex flex-row gap-4 items-center justify-center">
        <img src="{{ asset('storage/' . $course->image) }}" alt="Imagem do Curso" class="w-24 h-24 object-cover rounded">
        <div>
            <h2 class="text-lg font-semibold">{{ $course->title }}</h2>
            <p class="text-gray-700">
                R$ {{ number_format($course->price, 2, ',', '.') }}
            </p>
        </div>
    </div>

    <form id="checkout-form">
        @csrf

        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <input type="hidden" id="amount" value="{{ $course->price }}">

        @guest
            <label class="font-medium">Nome</label>
            <input type="text" id="buyer_name" required class="border rounded w-full mb-3 px-3 py-2">

            <label class="font-medium">Email</label>
            <input type="email" id="buyer_email" required class="border rounded w-full mb-3 px-3 py-2">

            <label class="font-medium">CPF</label>
            <input type="text" id="buyer_cpf" required class="border rounded w-full mb-3 px-3 py-2"
                placeholder="000.000.000-00">

            <label class="font-medium">Telefone</label>
            <input type="text" id="buyer_phone" required class="border rounded w-full mb-3 px-3 py-2"
                placeholder="(34) 90000-0000">
        @else
            <input type="hidden" id="buyer_name" value="{{ Auth::user()->name }}">
            <input type="hidden" id="buyer_email" value="{{ Auth::user()->email }}">
            <input type="hidden" id="buyer_cpf" value="{{ Auth::user()->cpf }}">
            <input type="hidden" id="buyer_phone" value="{{ Auth::user()->phone }}">
        @endguest


        <button type="button" id="checkout-button" class="mt-4 w-full bg-indigo-600 text-white py-3 rounded">
            Pagar agora
        </button>
    </form>

    <script>
        const phoneInput = document.querySelectorAll('#buyer_phone');
        const cpfInput = document.querySelectorAll('#buyer_cpf');

        // Máscara para telefone
        if (phoneInput.length > 0) {
            phoneInput.forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.slice(0, 11);

                    if (value.length > 10) {
                        // Celular: (99) 99999-9999
                        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                    } else if (value.length >= 2 && value.length <= 10) {
                        // Fixo: (99) 9999-9999
                        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                    }

                    e.target.value = value;
                });
            });
        }

        // Máscara para CPF
        if (cpfInput.length > 0) {
            cpfInput.forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 11) value = value.slice(0, 11);

                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                    value = value.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})/, '$1.$2.$3-$4');

                    e.target.value = value;
                });
            });
        }        

        const stripe = Stripe("{{ $stripeKey }}");

        const btn = document.getElementById("checkout-button");
        btn.addEventListener("click", async () => {
            btn.disabled = true;
            btn.innerText = "Redirecionando...";

            const response = await fetch("{{ route('checkout.create', $course->uuid) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    buyer_name: document.getElementById("buyer_name")?.value || "",
                    buyer_email: document.getElementById("buyer_email")?.value || "",
                    buyer_cpf: document.getElementById("buyer_cpf")?.value || "",
                    buyer_phone: document.getElementById("buyer_phone")?.value || "",                    
                })
            });

            const data = await response.json();

            if (data.error) {
                alert("Erro ao criar sessão Stripe: " + data.error);
                btn.disabled = false;
                btn.innerText = "Pagar agora";
                return;
            }

            const {
                error
            } = await stripe.redirectToCheckout({
                sessionId: data.id
            });

            if (error) {
                alert(error.message);
                btn.disabled = false;
                btn.innerText = "Pagar agora";
            }
        });
    </script>
</x-stripe-layout>
