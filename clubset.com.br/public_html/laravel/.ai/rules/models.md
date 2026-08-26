---
paths:
  - app/Models/User.php
---

# Models

## Tipar datas com CarbonInterface (CarbonImmutable global)
O app usa CarbonImmutable globalmente (Date::use). Métodos como markPaymentDue()/blockAccount() devem tipar o parâmetro de data como Carbon\CarbonInterface, nunca Illuminate\Support\Carbon, senão now() (que retorna CarbonImmutable) quebra em tempo de execução nos testes.
