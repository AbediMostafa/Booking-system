import axios from 'axios';
import Swal from 'sweetalert2';
import HeaderPart from '../components/packages/Header-part.vue';


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
    },

    data: {
        headerInfos: {
            imageSrc: sot.absImgPath('carousel/2.jpg'),
            title: 'ورود',
            text: `لطفا برای ورود به سایت شماره تلفن همراه خود را وارد کنید.
            `
        },
        phoneNumber: '',
        confirmCode: '',
        sendPhoneNumberStep: true,
        sendConfirmCodeStep: false,
        backUrl,
    },

    methods: {
        sendConfirmCode() {
            axios.post('/get-confirm-number', { phoneNumber: this.phoneNumber }).then(response => {
                if (response.data.status) {
                    this.sendPhoneNumberStep = false;
                    this.sendConfirmCodeStep = true;
                } else {
                    Swal.fire({
                        title: 'خطا',
                        text: response.data.msg,
                        icon: error,
                        showConfirmButton: true,
                    });
                }
            }).catch(error => {
                if (error.response.status == 422) {
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

                }
            });
        },

        submitConfirmCode() {
            axios.post('/submit-confirm-code', { confirmCode: this.confirmCode }).then(response => {
                if (response.data.status) {
                    if (this.backUrl == 'home') {
                        location.href = '/';
                        return;
                    }

                    if (this.backUrl.split('_')[0] == 'room') {
                        let roomId = this.backUrl.split('_')[1];

                        location.href = `/rooms/${roomId}`;
                        return;
                    }

                    location.href = `/insert-comment/${this.backUrl}`;
                } else {
                    Swal.fire({
                        title: 'خطا',
                        html: response.data.msg,
                        icon: 'error',
                        confirmButtonText: 'باشه'
                    });
                }
            });
        }
    }
});