const {default: axios} = require('axios');

window._ = require('lodash');
window.axios = require('axios');
window.Swal = require('sweetalert2')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.sot = require('./sot').sot;
window.cc = (msg, msg1 = null, msg2 = null) => {

    if (msg1) {
        console.log(msg, msg1)
        return
    }

    if (msg2 && msg1) {
        console.log(msg, msg1, msg2)
        return
    }

    if (msg2) {
        console.log(msg, msg2)
        return
    }
    console.log(msg)
}

window.swalDelete = callB =>
    Swal.fire({
        title: "آیا از حذف اطمینان دارید",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "خیر",
        confirmButtonText: "بله، پاکش کن",
    }).then(result => result.isConfirmed && callB());


window.displayErrors = (errorArray, callB) => {

    var errors = '';

    _.forOwn(errorArray, (value, key) => {
        errors += callB(value) + '<br>'
    });

    Swal.fire({
        title: 'خطا',
        html: errors,
        icon: 'error',
        confirmButtonText: 'باشه'
    });
}
window.successProcess = response => {

    let stat = response.data.status,
        msg = response.data.msg;
    if (stat === 'custom') return;

    Swal.fire({
        position: stat ? "bottom-end" : "",
        icon: stat ? "success" : "error",
        title: stat ? "" : "خطا",
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
