---
paths:
  - 'app/**/*.php'
---

# App

## Cashier 16: webhooks via WebhookReceived e rota auto-registrada
Cashier 16 não tem mais o macro Route::stripeWebhooks() e não dispara eventos de invoice (InvoicePaymentSucceeded/Failed). A rota /stripe/webhook (nome cashier.webhook) é auto-registrada. Trate webhooks ouvindo o evento WebhookReceived e lendo $payload bruto (AppServiceProvider::boot).
