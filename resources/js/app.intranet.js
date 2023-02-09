require('./bootstrap');
import Alpine from 'alpinejs';
import isMobile from 'ismobilejs';
window.Alpine = Alpine;

Alpine.data('appData', () => ({
    sideBar: !isMobile(window.navigator).any
}))

Alpine.start();
