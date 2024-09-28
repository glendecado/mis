import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});





///notifacations count
let userId = atob(window.currentUser);
let role = atob(window.currentUserType);
console.log('user: ' + userId + '\n');
console.log('role: ' + role);



if(role == 'Mis Staff'){
    window.Echo.private('NewRequest.' + userId).listen('RequestEventMis', (event) => {

        document.getElementById('request-count').innerHTML = event.count;

    });
}



window.Echo.private('Notif.' + userId).listen('NotifEvent', (event) => {

    document.getElementById('notif-count').innerHTML = event.count;

});
