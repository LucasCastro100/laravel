<x-stripe-layout title="Processando Pagamento...">

    <h1 class="text-lg font-bold mb-3">Processando pagamento...</h1>

    <p>Aguarde, confirmando com a Stripe.</p>

    <script>
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get("redirect_status") === "succeeded") {
            const paymentIntentId = urlParams.get("payment_intent");

            window.location.href =
                "{{ route('payment.success') }}" + "?payment_intent=" + paymentIntentId;
        }
    </script>

</x-stripe-layout>
