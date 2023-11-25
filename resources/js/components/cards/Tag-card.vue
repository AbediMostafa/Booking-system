<template>
    <div
        class="d-card-container"
    >
        <div class="d-card-text">{{card.name}}</div>

    </div>
</template>

<script>

export default {
    data() {
        return {
            enterAnimations: sot.enterAnimations,
        };
    },
    props: ["card"],
    computed: {
        roomStyle() {
            let image = this.card.image ? this.card.image : sot.noImage;
            return `background: url('${image}') no-repeat center center/cover;`;
        },
    },
    methods: {
        editCard(){
            this.$emit('beforeEdit', {
                id:this.card.id,
                name:this.card.name,
            })
        }
    },
};
</script>

<style scoped>
.d-card-image{
    height: 5rem;
    border-radius: 10px;
    box-shadow: 0 0px 27px 3px rgb(0 0 0 / 6%);
}
</style>
