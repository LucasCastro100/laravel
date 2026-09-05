---
paths:
  - 'resources/js/pages/**'
---

# Pages

## Usar ActionIconButton para botões de ação com ícone+tooltip
Ações de listagem/tabela que são botão-ícone com legenda devem usar o componente ActionIconButton (resources/js/components/action-icon-button.tsx). Props: icon, label (texto da tooltip/aria-label), cor via variant + className, função via onClick/form (wayfinder RouteFormDefinition) ou href. Não repetir Tooltip+Button na mão.
