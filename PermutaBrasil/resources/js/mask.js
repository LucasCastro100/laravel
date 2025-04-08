export const formatters = {
    phone: (value) => {
        if (!value) return '';
        value = value.replace(/\D/g, ''); // Remove não dígitos
        value = value.replace(/^(\d{2})(\d)/g, '($1) $2'); // Formata DDD
        value = value.replace(/(\d)(\d{4})$/, '$1-$2'); // Formata número
        return value;
    }
};

export const setupMasks = () => {
    console.log("setupMasks called"); // Para verificar se a função é chamada
    const inputs = document.querySelectorAll('[data-mask]');
    
    inputs.forEach(input => {
        const maskType = input.dataset.mask;
        
        if (maskType === 'tel') {
            input.addEventListener('input', (e) => {
                const formatted = formatters.phone(e.target.value);
                e.target.value = formatted;
                
                // Dispara um evento do Livewire para atualizar o valor
                input.dispatchEvent(new Event('input', { bubbles: true }));
            });
            
            // Define o maxlength
            input.setAttribute('maxlength', 15); // Ajuste conforme necessário
        }
    });
};