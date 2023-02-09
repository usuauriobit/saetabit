import { Notyf } from 'notyf';

var notyf = new Notyf({
    duration: 7000
});
window.livewire.on('notify', (type, title = '', text = '') => {
    switch (type) {
        case 'success':
            notyf.success(title);
            break;
        case 'info':
            notyf.success(title);
        case 'warning':
            notyf.warning(title);
        case 'error':
            notyf.error(title);
            break;
    }
})
