# REGRAS GLOBAIS DO PROJETO

## MEMÓRIA PERSISTENTE
1. **Leitura Obrigatória:** ANTES de qualquer tarefa, leia nesta ordem:
   - `.opencode/memory.md`
   - `.opencode/rules/global.md` (este arquivo)
   - `.opencode/rules/laravel-security.md` (se a tarefa envolver `app/`, `routes/` ou `resources/views/`)
2. **Atualização Automática:** Ao concluir alterações, ATUALIZE `.opencode/memory.md` sem perguntar. Registre novos componentes, controllers, policies, rotas ou correções aplicadas com a data.
3. **Notificação:** Ao finalizar, inclua no fim da resposta: `[Memória do projeto atualizada em .opencode/memory.md]`.

## PADRÕES DE CÓDIGO
- **Componentização:** Se um trecho HTML/UI se repetir ou for extenso, crie/reutilize um componente em `resources/views/components/` (`<x-nome />`). Proibido código Blade limpo poluído com HTML repetido.
- **Performance:** Faça consultas Eloquent otimizadas (`select` explícito) e evite queries N+1 usando `with()`. Prefira Alpine.js/JS nativo a bibliotecas pesadas.
- **Segurança:** Sanitização estrita (`{{ }}`). Uso de `{!! !!}` apenas sob autorização explícita. Exija FormRequests para validações e valide autorização com Policies/Gates.
- **Layout:** Mantenha estritamente o padrão de classes Tailwind CSS / CSS existente no projeto. Garanta responsividade nativa.

## FORMATO DE SAÍDA
- Seja enxuto e direto. Evite introduções longas ou explicações desnecessárias para economizar tokens.