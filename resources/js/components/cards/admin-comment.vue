<template>
    <div :class="['comments-boxes', comment.isComment?'':'comment-answer-box']">
        <div>
            <!-- The modal -->
            <b-modal :id="`reserve-detail-modal${comment.id}`" hide-footer>
                <b-container>
                    <div class="rtl-dir text-sm chkout-dtil-cntinr">
                        <p class="checkout-room-details-header mt-0">
                            <strong>
                                پاسخ به کامنت
                            </strong>
                        </p>

                        <div class="mt-8">
                            <b-form>
                                <b-form-textarea
                                    id="textarea"
                                    v-model="commentAnswer"
                                    rows="3"
                                    class="mb-2 mr-sm-2 mb-sm-0"
                                    max-rows="6"
                                ></b-form-textarea>

                                <b-button variant="success" @click="sendAnswer" class="btn-sm mt-4">
                                    <span>ارسال پاسخ</span>
                                </b-button>
                            </b-form>
                        </div>

                    </div>
                </b-container>

            </b-modal>
        </div>
        <p class="comment-date">{{ comment.date }} - {{ comment.isComment ? 'کامنت' : 'پاسخ به کامنت' }}</p>

        <div :class="[comment.situation === 'promoted' ? 'between-flex':'']">

            <div>
                <span class="admin-comment-answer admin-comment-answer-delete ml-2" @click.stop="deleteAnswers()"
                      v-if="selectedEntities.length && userHasAccess">
                        حذف پاسخ ها
                </span>

                <span class="admin-comment-answer" @click.stop="answerToComment(comment)"
                      v-if="comment.situation === 'promoted'">
                    پاسخ دادن
                </span>
            </div>

            <h4>{{ comment ? comment.user.name : "" }}</h4>
        </div>

        <template v-if="comment.isComment">
            <score-stars :score="comment.user.rate"></score-stars>
            <div class="comment-recommend" v-if="comment.status == 'agree'">
                <span class="recomend-text">توصیه می کنم</span>
                <img class="recommend-icons" :src="iconPath('blue-check.svg')"/>
            </div>
            <div class="comment-recommend" v-if="comment.status == 'disagree'">
                <span class="not-recomend-text">توصیه نمی کنم</span>
                <img class="recommend-icons" :src="iconPath('red-uncheck.svg')"/>
            </div>
            <ul class="end-flex flex-wrap mt-2" v-if="comment.rates">

                <li class="comment-rates" v-for="(rate, key) in rates" :key="key">
                    {{ rate }} {{ comment.rates[key] }}
                </li>
            </ul>

        </template>

        <p class="comments-boxes-p">{{ comment.body }}</p>

        <div
            v-for="(child , key) in comment.childs"
            :class="[
            'admin-comment-answer-box',
            selectedEntities.includes(child.id) ? 'selected-checked-item' : '',
            ]"
            @click.stop="cardClicked(child)"
        >
            <h5 class="acab-username">{{ child.user }}</h5>
            <p class="acab-body">{{ child.body }}</p>
        </div>
        <div class="comment-thumbs-container">
            <div class="cth-up-container cth-containers" @click="vote('agree')">
                {{ comment.room }}
            </div>
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
            currentComment: '',
            commentAnswer: '',
            selectedEntities: [],
        }
    },
    props: ["comment", "rates"],
    methods: {

        deleteAnswers() {
            axios.post('/admin/comment/delete', {comments: this.selectedEntities}).then(() => {
                this.$parent.getEntities();
                this.selectedEntities = [];
            })
        },
        cardClicked(entity) {

            if(!this.userHasAccess){
                return;
            }

            if (this.selectedEntities.includes(entity.id)) {
                this.selectedEntities = _.without(this.selectedEntities, entity.id);
            } else {
                this.selectedEntities.push(entity.id);
            }
        },

        answerToComment(comment) {
            this.currentComment = comment;
            this.$bvModal.show(`reserve-detail-modal${this.comment.id}`);
        },
        sendAnswer() {
            let data = {
                responder: 'room_owner',
                answer: this.commentAnswer
            }

            axios.post(`/comments/${this.currentComment.id}/answer`, data).then(response => {
                this.$bvModal.hide(`reserve-detail-modal${this.comment.id}`);
            })
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },
    computed:{
        userHasAccess() {
            return user.type === 'admin' || user.type === 'manager';
        }
    }
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

.cth-up-container {
    background: var(--background1);
    padding: .3rem 1.1rem;
    border-radius: 0.5rem;
    font-size: 0.7rem;
}

.cth-containers:hover {
    box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
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
    margin-top: 1.5rem;
}
</style>
