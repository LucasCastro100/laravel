import './bootstrap';

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse' // Importando o plugin de collapse

Alpine.plugin(collapse) // Instalando o plugin

window.Alpine = Alpine
Alpine.start()