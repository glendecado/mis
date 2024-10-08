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





let userId = atob(window.currentUser);
let role = atob(window.currentUserType);
console.log('user: ' + userId + '\n');
console.log('role: ' + role);


//total count of request on live
if (role == 'Mis Staff') {
    window.Echo.private('NewRequest.' + userId).listen('RequestEventMis', (event) => {

        document.getElementById('request-count').innerHTML = event.count;

    });
}


if (role === 'Faculty') {
    window.Echo.private('Notif.' + userId).listen('NotifEvent', (event) => {
        let count = document.getElementById('notif-count');
        let notifContainer = document.getElementById('notif');
        let messageElement = document.createElement('div');
        let dateElement = document.createElement('div');

        // Update count
        count.innerHTML = event.count;

        // Create notification message and date
        messageElement.innerHTML = event.notifData.message;
        dateElement.innerHTML = event.notifData.date;

        // Append to the notification container
        notifContainer.appendChild(messageElement);
        notifContainer.appendChild(dateElement);

        console.log('Notification received: ', event.notifData);
    });
}