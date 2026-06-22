import './bootstrap';

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse' // Importando o plugin de collapse

window.previewImage = function previewImage(event, options = {}) {
    const {
        previewImageId = 'image-preview',
        previewContainerId = 'image-preview-container',
        imageFromDbId = 'image-from-db',
        displayClass = ['flex', 'items-center', 'justify-center'],
    } = options;

    const file = event?.target?.files?.[0];

    if (!file) return;

    const reader = new FileReader();
    const previewImage = document.getElementById(previewImageId);
    const previewContainer = document.getElementById(previewContainerId);
    const imageFromDb = document.getElementById(imageFromDbId);

    if (imageFromDb) {
        imageFromDb.remove();
    }

    reader.onload = (e) => {
        if (previewImage) {
            previewImage.src = e.target.result;
        }

        if (previewContainer) {
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add(...displayClass);
        }
    };

    reader.readAsDataURL(file);
};

Alpine.plugin(collapse) // Instalando o plugin

window.Alpine = Alpine
Alpine.start()
