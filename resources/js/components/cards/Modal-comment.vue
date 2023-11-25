<template>
    <div class="comments-boxes">
        <p class="comment-date">{{ comment.date }}</p>
        <h4>{{ userName }}</h4>
        <score-stars :score="commentRate"></score-stars>
        <div class="comment-recommend" v-if="comment.status == 'agree'">
            <img class="recommend-icons" :src="iconPath('blue-check.svg')"/>
        </div>
        <div class="comment-recommend" v-if="comment.status == 'disagree'">
            <img class="recommend-icons" :src="iconPath('red-uncheck.svg')"/>
        </div>

        <p class="comments-boxes-p">{{ comment.body }}</p>

        <div v-for="(child , key) in comment.childs" class="admin-comment-answer-box">

            <div class="flex-start">
                <h5 class="acab-username mr-2">{{ child.user }}</h5>
            </div>
            <p class="acab-body">{{ child.body }}</p>
        </div>


        <div class="mt-8">

            <div class="d-form-input">
                <textarea
                    type="text"
                    class="d-search-input"
                    v-model="answer"
                >
                </textarea>

            </div>
        </div>
    </div>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";
import axios from "axios";

export default {
    components: {
        ScoreStars,
    },
    data() {
        return {
            answer: ''
        }
    },
    props: ["comment"],

    computed: {
        commentRate() {
            return this.comment && this.comment.user ? this.comment.user.rate : '';
        },
        userName() {
            return this.comment && this.comment.user ? this.comment.user.name : '';
        }
    },
    methods: {

        sendAnswer() {

            let data = {
                answer: this.answer,
            }

            axios.post('/auth-check').then(response => {
                if (response.data) {
                    axios.post(`/comments/${this.comment.id}/answer`, data).then(response=>{
                        successProcess(response);
                        this.$parent.closeModal();
                        this.answer = '';
                    })
                } else {
                    location.href = `/phone-check/room_${this.comment.roomId}`;
                }
            });
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },
};
</script>

<style scoped>
.comments-boxes h4 {
    font-size: 1.1rem;
}

.comment-recommend {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin-top: 0.2rem;
}

.recommend-icons {
    width: 1rem;
    margin-left: 0.4rem;
}

.not-recomend-text {
    font-size: 0.8rem;
    color: #bd4040;
}

.recomend-text {
    color: #176087;
    font-size: 0.8rem;
}

.comments-boxes {
    cursor: initial;
}
</style>
