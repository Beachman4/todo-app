
window._ = require('lodash');
window.Cookie = require('cookies-js');

window.axios = require('axios')

let token = document.head.querySelector('meta[name="csrf-token"]');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': token.content,
    'X-Requested-With': 'XMLHttpRequest'
};

window.axios.defaults.baseURL = 'api'
if (Cookie.get('todoToken') && Cookie.get('todoToken') != undefined) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + Cookie.get('todoToken');
}

window.Cookie = require('cookies-js');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */



/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
