import axios from 'axios';
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
                if (response.data) {
                    this.sendPhoneNumberStep = false;
                    this.sendConfirmCodeStep = true;
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

                    location.href = `/insert-comment/${this.backUrl}`;
                }
            });
        }
    }
});