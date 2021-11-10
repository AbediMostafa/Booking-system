<template>
    <div>
        <div class="header-and-cta custom-header-cta">
            <div class="search-header-section" v-scrollAnimation="enterAnimations.topAnimation">
                <div class="title-icon justify-center">
                    <h1>{{ this.multimediaData ? this.multimediaData.title:'' }}</h1>
                </div>
                <p class="header-text">
                    {{ this.multimediaData ? this.multimediaData.text:'' }}
                </p>
            </div>
        </div>
        <div class="learning-card-container">
            <learning-card
                v-for="(multimedia, key) in multimedis"
                :key="key"
                :card="multimedia"
                :uri="multimedia.type"
                class="multimedia-learning-card"
            ></learning-card>
        </div>
    </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import LearningCard from "../cards/Learning-card.vue";
export default {
    props:['multimediaData'],
    components: {
        SectionHeader,
        LearningCard,
    },
    data() {
        return {
            enterAnimations: sot.enterAnimations,
            multimedis: [],
        };
    },

    computed:{
        titles(){
            return {
                mainTitle: this.multimediaData?this.multimediaData.title:'',
                icon: true,
                secondTitle: "",
                text: this.multimediaData?this.multimediaData.text:''
            };
        },

        multimediaUri(){
            return ;
        }
    },
    methods: {
        getMultimedia() {

            axios.post("/multimedia", {method:'actionIndex'}).then((response) => {
                this.multimedis = response.data.data;
            });
        },
    },
    created() {
        this.getMultimedia();
    },
};
</script>

<style scoped>
</style>
