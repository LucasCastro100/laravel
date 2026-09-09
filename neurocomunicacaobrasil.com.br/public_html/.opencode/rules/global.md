# PROMPT GLOBAL & PADRÕES DO PROJETO

## REGRA SUPREMA DE CONTEXTO
Antes de iniciar qualquer tarefa, LEIA SEMPRE o arquivo `.opencode/MEMORY.md`. 
Após concluir qualquer alteração significativa, ATUALIZE o arquivo `.opencode/MEMORY.md` com o resumo do que foi feito.

## PADRÕES DE DESENVOLVIMENTO

### 1. Blade & Componentização
- Avalie sempre a reutilização: Se um trecho HTML/UI for repetido mais de uma vez ou for extenso, CRIE UM COMPONENTE BLADE (`<x-nome-componente />`).
- Evite código limpo poluído com HTML repetitivo direto na view.

### 2. Velocidade & Performance
- Priorize consultas Eloquent otimizadas (`select` de campos necessários, evitando *N+1* usando `with()`).
- Minimize dependências JS pesadas nas views; prefira manipulação nativa/Alpine.js se aplicável.

### 3. Segurança (Core)
- Sanitização rigorosa (`{{ }}`). Uso de `{!! !!}` apenas sob autorização explícita.
- Aplique FormRequests para validações e sempre verifique autorização via Policies/Gates.

### 4. Padronização de Layout & UI
- Mantenha estritamente o mesmo padrão de classes Tailwind CSS / CSS existente nos componentes do projeto.
- Garanta responsividade nativa em todas as alterações de interface.