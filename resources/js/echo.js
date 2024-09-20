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




// Get the user ID from a meta tag in the HTML document
const userId = document.querySelector('meta[name="user-id"]').content;

// Set up a private channel with Laravel Echo for real-time listening, using the user ID
// The channel is named 'NewRequest.<userId>' and listens for the 'RequestEventMis' event
window.Echo.private('NewRequest.' + userId).listen('RequestEventMis', (event) => {

  //updates anything that has the Id request-count
    document.getElementById('request-count').innerHTML = event.count;
/* 
    // Log the event details to the console for debugging
    console.log(event); */
});