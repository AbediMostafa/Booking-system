<template>
    <div class="learning-container">
        <div class="header-and-cta">
            <section-header
                :titles="titles"
                v-scrollAnimation="enterAnimations.topAnimation"
            ></section-header>

            <div class="text-right">
                <a class="cta main-cta learning-cta" href="/learn">{{جستجوی پیشرفته}}</a>
            </div>
        </div>
        <div class="learning-card-container">
        </div>
    </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import LearningCard from "../cards/Learning-card.vue";
export default {
    props:['learningData'],
    components: {
        SectionHeader,
    },
    data() {
        return {
            enterAnimations: sot.enterAnimations,
        };
    },

    computed:{
        titles(){
            return {
                mainTitle: 'جستجو بر روی همه اتاق های فرار',
                icon: true,
                secondTitle: '',
                text: "نام اتاق فرار خود را در مخزن اتاق های فرار میس اسکیپ جستجو کنید"
            };
        }
    },
};
</script>

<style scoped>
.learning-cta {
    margin-right: 1.5rem;
}
</style>
