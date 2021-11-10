<template>
    <div class="d-item-container item-container-with-min-height">
        <div>
            <!-- The modal -->
            <b-modal id="score-increase-comment" hide-footer>
                <b-container>
                    <div class="rtl-dir text-sm chkout-dtil-cntinr">
                        <p class="checkout-room-details-header mt-0">
                            <strong>
                                افزایش امتیاز
                            </strong>
                        </p>

                        <div class="mt-8"  v-html="howToText">
                        </div>

                    </div>
                </b-container>

            </b-modal>
        </div>
        <div class="d-status-bar flex-end">
            <h5 class="create-media-title">
                {{ userName }}
            </h5>
        </div>

        <div class="p-6">
            <div class="flex-center mt-8">
                <span class="user-total-score mr-6">
                    <p class="user-score-digit">{{score}}</p>
                    <p class="user-score-text">مجموع امتیازات</p>
                </span>

                <span class="user-total-score">
                    <p class="user-score-digit">{{reservationCount}}</p>
                    <p class="user-score-text">تعداد رزرو</p>
                </span>
            </div>

            <div class="flex-center mt-8 ">
                <a class="text-msm mr-2 pointer-cursor how-to-increase-score" @click="howToIncreaseScore">
                    چگونه می توانم امتیازات خود را افزایش دهم؟
                </a>
                <b-icon icon="patch-question" style="color:#5378a4"></b-icon>
            </div>
            <div class="increase-image-container">
                <img src="/images/general/increase-score.png" alt="increase score image">
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import MyComplicatedRoomCard from '../../cards/MyComplicated-room-card.vue';

export default {
    components: {},
    data() {
        return {
            userName: '',
            reservationCount:0,
            score:0,
            howToText:''
        };
    },
    methods: {
        howToIncreaseScore(){
            this.$bvModal.show('score-increase-comment');
        },
        getUserInfos() {
            axios.get('users').then((response) => {
                this.reservationCount = response.data.reservationCount;
                this.score = response.data.score;
                this.howToText = response.data.howtoText;
            });
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },

    created() {
        this.userName = user.name
        this.getUserInfos();
    },
};
</script>

<style scoped>

.d-inner-type-filter li {
    width: 6.5rem;
    font-size: 0.75rem;
}

.pointer {
    cursor: pointer;
}

.d-grant-cta {
    background: #65a856;
}
</style>
