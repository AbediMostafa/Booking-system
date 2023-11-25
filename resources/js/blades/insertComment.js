import axios from 'axios';
import HeaderPart from '../components/packages/Header-part.vue';


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
    },

    data: {
        headerInfos: {
            text: `
            `
        },
        postData: {
            scoresTitles: {
                scariness: {title: '', selectedKey: ''},
                room_decoration: {title: '', selectedKey: ''},
                hobbiness: {title: '', selectedKey: ''},
                creativeness: {title: '', selectedKey: ''},
                mysteriness: {title: '', selectedKey: ''},
            },

            roomInfo,
            selectedStatus: '',
            comment: ''
        },

        digits: [1, 2, 3, 4, 5],
        commentingRules,
    },

    computed: {
        sendComment() {
        }
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

            let url = type == 'edit' ? `/edit-comment/${this.postData.roomInfo.id}` : '/submit-comment';

            axios.post(url, this.postData).then(response => {
                if (response && typeof response.data === 'object' && 'status' in response.data) {

                    let stat = response.data.status,
                        msg = response.data.msg;

                    Swal.fire({
                        position: stat ? "bottom-end" : "",
                        icon: stat ? "success" : "error",
                        title: stat ? "" : "error",
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
                    title: 'error',
                    html: errors,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            });
        }
    },

    created() {
        axios.post('/site-vars/rate-titles').then(response => {

            if (type == 'edit') {
                this.postData = comment;
            }

            let titles = this.postData.scoresTitles;

            titles.scariness.title = response.data.scariness
            titles.room_decoration.title = response.data.room_decoration
            titles.hobbiness.title = response.data.hobbiness
            titles.creativeness.title = response.data.creativeness
            titles.mysteriness.title = response.data.mysteriness
        });
    },
});
