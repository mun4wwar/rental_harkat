import './bootstrap';
import Alpine from 'alpinejs';
import { createIcons, icons  } from 'lucide';

window.Alpine = Alpine;
Alpine.start();

window.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});
