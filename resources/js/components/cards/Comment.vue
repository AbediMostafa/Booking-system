<template>
    <div class="comments-boxes">
        <div class="between-flex">
            <div>
                <span class="comment-edit" v-if="comment.user.is_owner">
                    <a :href="`/edit-comment/${comment.id}`">
                        ویرایش
                    </a>
                </span>
            </div>

            <div>
                <p class="comment-date">{{ comment.date }}</p>
                <h4>{{ comment ? comment.user.name : "" }}</h4>
            </div>
        </div>
        <score-stars :score="comment.user.rate"></score-stars>
        <div class="comment-recommend" v-if="comment.status == 'agree'">
            <span class="recomend-text">توصیه می کنم</span>
            <img class="recommend-icons" :src="iconPath('blue-check.svg')"/>
        </div>
        <div class="comment-recommend" v-if="comment.status == 'disagree'">
            <span class="not-recomend-text">توصیه نمی کنم</span>
            <img class="recommend-icons" :src="iconPath('red-uncheck.svg')"/>
        </div>

        <p class="comments-boxes-p">{{ comment.body | truncate(200, ' ... ') }}</p>
        <div class="comment-thumbs-container">
            <div class="cth-up-container cth-containers" @click="vote('agree')">
                <img class="thumb-image" :src="iconPath('thumbs-up.svg')"/>
                <span class="thumb-text">{{ upRate }}</span>
            </div>
            <div class="cth-down-container cth-containers" @click="vote('disagree')">
                <img class="thumb-image" :src="iconPath('thumbs-down.svg')"/>
                <span class="thumb-text">{{ downRate }}</span>
            </div>
        </div>
        <div class="admin-comment-answer-box" v-if="comment.childs.length">
            <div class="flex-start">
                <img src="/images/icons/logo.svg" class="answer-logo" alt="لوگوی سایت" v-if="comment.childs[0].userIsManager">
                <h5 class="acab-username mr-2">{{comment.childs[0].user}}</h5>
            </div>
            <p class="acab-body">{{comment.childs[0].body | truncate(200, ' ... ')}}</p>
        </div>
        <div class="load-more-answers" v-if="comment.childs.length>1">
            {{`مشاهده ${comment.childs.length - 1} پاسخ دیگر`  }}
        </div>
    </div>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";

export default {
    components: {
        ScoreStars,
    },
    data() {
        return {
            upRate: 0,
            downRate: 0,
        };
    },
    props: ["comment"],
    methods: {
        vote(type) {
            axios.post("/auth-check").then((response) => {
                if (!response.data) {
                    location.href = `/phone-check/room_${this.comment.roomId}`;
                    return;
                }
                axios
                    .post(`/vote/${type}/comment/${this.comment.id}`)
                    .then((result) => {
                        if (!result.data.status) {
                            Swal.fire({
                                title: "خطا",
                                html: "مشکلی در ثبت نظر به وجود آمده",
                                icon: "error",
                                confirmButtonText: "باشه",
                            });
                            return;
                        }

                        result.data.increaseAgree ? this.upRate++ : "";
                        result.data.decreaseAgree ? this.upRate-- : "";
                        result.data.increaseDisagree ? this.downRate++ : "";
                        result.data.decreaseDisagree ? this.downRate-- : "";
                        return;
                    });
            });
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },

    filters: {
        truncate(text, length, suffix) {

            return text.length > length ? text.substring(0, length) + suffix : text

        }
    },

    created() {
        this.upRate = parseInt(this.comment.up_rate);
        this.downRate = parseInt(this.comment.down_rate);
    },
};
</script>

<style scoped>
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

.cth-up-container,
.cth-down-container {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 16%;
    background: var(--background1);
    padding: 0.3rem 0.5rem;
    border-radius: 0.5rem;
    margin-left: 0.7rem;
    cursor: pointer;
    transition: all 300ms;
}

.cth-containers:hover {
    box-shadow: 0 0 1rem 0 rgb(0 0 0 / 20%);
}

.thumb-image {
    width: 1rem;
    margin-right: 0.3rem;
}

.thumb-text {
    font-size: 0.8rem;
}

.comment-thumbs-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin:1rem 0;
}
</style>
