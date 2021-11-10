<template>
    <div class="right-carot-container">
        <div class="carot-child-container">
            <img :src="rightArrow" class="card-left-carot"/>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        txt: {
            default: "اطلاعات بیشتر",
        },
        additionalClass: {
            default: "",
        },
        position: {
            default: "end",
        },
    },
    data() {
        return {
            rightArrow: sot.iconPath("left-carot.svg"),
        };
    },
};
</script>
<style scoped>
.right-carot-container {
    display: flex;
    align-items: center;
    text-align: right;
    justify-content: flex-start;
    position: absolute;
    bottom: 0;
    left: 0;
}
</style>
