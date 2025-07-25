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

window.addEventListener('load', async (event) => {
        setTimeout(async () => {
            await execMasks()
        }, 300)
})