const {default: axios} = require('axios');

window._ = require('lodash');
window.axios = require('axios');
window.Swal = require('sweetalert2')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.sot = require('./sot').sot;

window.swalDelete = callB =>
    Swal.fire({
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
    }).then(result => result.isConfirmed && callB());


window.displayErrors = (errorArray, callB) => {

    var errors = '';

    _.forOwn(errorArray, (value, key) => {
        errors += callB(value) + '<br>'
    });

    Swal.fire({
        title: 'error',
        html: errors,
        icon: 'error',
        confirmButtonText: 'Ok'
    });
}
window.successProcess = response => {

    let stat = response.data.status,
        msg = response.data.msg;
    if (stat === 'custom') return;

    Swal.fire({
        position: stat ? "bottom-end" : "",
        icon: stat ? "success" : "error",
        title: stat ? "" : "error",
        text: msg,
        showConfirmButton: !stat,
        timer: stat ? 2500 : "",
    });

}
window.frontSansPassedTime = 30;
window.backSansPassedTime = 7;
window.reservationScore = 10;

axios.interceptors.response.use(response => {

    if (response && typeof response.data === 'object' && 'status' in response.data) {
        successProcess(response);
    }

    return response
}, error => {

    if (error.response.status == 422) {
        displayErrors(error.response.data.errors, value => value[0])
    }

    return Promise.reject(error);
})
