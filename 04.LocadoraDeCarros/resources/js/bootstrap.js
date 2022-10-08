import _ from 'lodash';
window._ = _;

import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

/* interceptar os requests da aplicação */
axios.interceptors.request.use(
    config => {
        let cookies = document.cookie.split(';');
        
        let token = cookies.find(indice => {
            return indice.startsWith('token=');
        });                

        if (token) {
            token = 'Bearer ' + token.split('=')[1];

            config.headers.Accept = 'application/json';
            config.headers.Authorization = token;
        }
        
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);

/* interceptar os responses da aplicação */
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response && error.response.status && error.response.status == 401 && error.response.data.message == 'Token has expired') {
            axios.post('http://localhost:8000/api/refresh')
                .then(response => {
                    document.cookie = 'token' + response.data.token;
                    window.location.reload();
                });
        }
        
        return Promise.reject(error);
    }
);
