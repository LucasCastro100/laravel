const select = element => document.querySelector(element)
const selectAll = element => document.querySelectorAll(element)

const maskPhone = (value, element) => {
    element.setAttribute('maxlength', 15)

    value = value.replace(/\D/g, "");
    value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
    value = value.replace(/(\d)(\d{4})$/, "$1-$2");
    return element.value = value;
}

const maskCpf = (value, element) => {
    value = value.replace(/\D/g, "");
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return element.value = value;
}

const maskCnpj = (value, element) => {
    element.setAttribute('maxlength', 18);

    value = value.replace(/\D/g, "");
    value = value.replace(/^(\d{2})(\d)/, "$1.$2");
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
    value = value.replace(/(\d{4})(\d)/, "$1-$2");
    return element.value = value;
}

const execMasks = async () => {    
    const mask = selectAll('[data-mask]')
    const newMaks = Array.from(mask).filter(element => element.dataset.mask.trim() !== '');

    if (newMaks.length > 0) {
        newMaks.forEach(item => item.addEventListener('keyup', (event) => {
            let value = event.target.value

            switch (item.dataset.mask) {
                case 'cnpj':
                    let docFilter = maskCnpj(value, item)
                    break;

                case 'tel':
                    let telFilter = maskPhone(value, item)
                    break;
            }
        }))
    }
}

const toggleMenu = async () => {
    const aside = selectAll('aside')
    aside[0].classList.toggle('active')
}

const getIconMenuOpen = async () => {
    const getIconMenuOpen = selectAll('#dashboard header .main-header-info-icon i.fa-bars')

    getIconMenuOpen[0].addEventListener('click', toggleMenu)
}

const getIconMenuClose = async () => {
    const getIconMenuClose = selectAll('#dashboard aside .close-aside i.fa-xmark')

    getIconMenuClose[0].addEventListener('click', toggleMenu)
}

const maxLength = async () => {
    const valueExchange = select('#value_exchange')
    if (valueExchange) {
        valueExchange.setAttribute('maxlength', 6)
    }
}

const getCities = async (stateId) => {
    try {
        const response = await fetch(`https://permutabrasil.com.br/api/cities/${stateId}`);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro ao buscar cidades:', error);
    }
}

const getState = async () => {
    let html = ''
    const stateElement = select('select#state_id');
    const cityElement = select('datalist#searchCity');

    if (stateElement && cityElement) {
        stateElement.addEventListener('change', async () => {
            let selectedStateId = stateElement.value;
            let arrayCities = await getCities(selectedStateId)

            html = ''
            arrayCities.cities.forEach(item => {
                html += `<option value="${item.city}"></option>`
            })

            cityElement.innerHTML = html
        })
    }
}

const selectedMultiples = async () => {
    const selectElement = document.querySelector('[data-maxconection]');

    if (selectElement) {        
            let alertSMS = document.createElement('p');            
            alertSMS.style.marginTop = '0.5rem';
            alertSMS.style.color = 'red';
            alertSMS.style.fontSize  = '0.8rem';
            alertSMS.textContent = `segure SHIFT ou CTRL para selecionar vários`
            selectElement.parentNode.insertBefore(alertSMS, selectElement.nextSibling);
        

        const maxConnection = parseInt(selectElement.dataset.maxconection);

        selectElement.addEventListener('change', () => {            
            let selectedOptions = Array.from(selectElement.selectedOptions)
            let errorMessageElement = document.getElementById('error-message')
            

            console.log(selectedOptions.length, maxConnection)
            if (selectedOptions.length > maxConnection) {
                // Desselecionar o último item selecionado
                selectedOptions[selectedOptions.length - 1].selected = false;

                // Se a mensagem de erro já existir, não recrie
                if (!errorMessageElement) {
                    errorMessageElement = document.createElement('p');
                    errorMessageElement.id = 'error-message';
                    errorMessageElement.style.color = 'red';
                    errorMessageElement.style.marginTop = '5px';
                    errorMessageElement.textContent =
                        'Você pode selecionar no máximo ' + maxConnection + ' itens.';
                    selectElement.parentNode.insertBefore(errorMessageElement, alertSMS.nextSibling);
                }
            } else {
                // Remove a mensagem de erro, se existir
                if (errorMessageElement) {
                    errorMessageElement.remove();
                }
            }
        });
    }
};

window.addEventListener('load', async () => {
    setTimeout(async () => {
        await getIconMenuOpen()
        await getIconMenuClose()
        await execMasks()
        await maxLength()
        await getState()
        await selectedMultiples()
    }, 300)
})

document.addEventListener('livewire:init', () => {        
    Livewire.on('modalOpened', async () => {
        setTimeout(async () => {
            await execMasks(); 
        }, 200)
    });
});
