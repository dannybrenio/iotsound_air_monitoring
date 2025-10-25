import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true,          // hosted Pusher uses TLS; no host/port needed
});

// Listener (matches your ReadingReceived event with broadcastAs())
window.Echo.channel('readings')
  .listen('.reading.received', (e) => {
    console.log('✅ ReadingReceived:', e);
  });
