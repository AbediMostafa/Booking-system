const { default: axios } = require('axios');

window._ = require('lodash');
window.axios = require('axios');
window.Swal = require('sweetalert2')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.sot = require('./sot').sot

axios.interceptors.response.use(response => {

    if (response && typeof response.data === 'object' && 'status' in response.data) {

        let stat = response.data.status,
            msg = response.data.msg;

        Swal.fire({
            position: stat ? "bottom-end" : "",
            icon: stat ? "success" : "error",
            title: stat ? "" : "خطا",
            text: msg,
            showConfirmButton: !stat,
            timer: stat ? 2500 : "",
        });
    }

    return response
}, error => {
    var errors = '';

    _.forOwn(error.response.data.errors, (value, key) => {
        errors += value[0] + '<br>'
    });

    Swal.fire({
        title: 'خطا',
        html: errors,
        icon: 'error',
        confirmButtonText: 'باشه'
    });

    return Promise.reject(error);
})

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });