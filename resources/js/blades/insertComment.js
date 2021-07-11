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
                // console.log(response.data);
            });
        }
    }
});