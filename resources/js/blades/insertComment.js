import axios from 'axios';
import HeaderPart from '../components/packages/Header-part.vue';


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
    },

    data: {
        headerInfos: {
            title: 'ثبت نظر',
            text: `
            `
        },
        postData: {
            scoresTitles: {
                scariness: { title: 'درجه ترس', selectedKey: '' },
                room_decoration: { title: 'طراحی اتاق', selectedKey: '' },
                hobbiness: { title: 'سرگرمی', selectedKey: '' },
                creativeness: { title: 'خلاقیت', selectedKey: '' },
                mysteriness: { title: 'جذابیت داستان', selectedKey: '' },
            },

            roomInfo,
            selectedStatus: '',
            comment: ''
        },

        digits: [1, 2, 3, 4, 5],
    },

    methods: {
        iconPath(icon) {
            return sot.iconPath(icon);
        },
        selectScore(scoreTitleKey, key) {
            this.postData.scoresTitles[scoreTitleKey].selectedKey = key;
        },
        statusClicked(status) {
            this.postData.selectedStatus = status;
        },

        submitComment() {
            axios.post('/submit-comment', this.postData).then(response => {
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
                setTimeout(() => {
                    location.href = `/rooms/${this.postData.roomInfo.id}`
                }, 2000);

            }).catch(error => {
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
            });
        }
    }
});