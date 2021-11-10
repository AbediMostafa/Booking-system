<template>
    <div class="lsr-container">
        <div class="lsr-text-container">
            <div class="header-section">
                <div class="title-icon">
                    <img :src="iconPath" alt="icon"/>
                    <h1>{{ specialRoomData ? specialRoomData.title : "" }}</h1>
                </div>
                <p class="header-text">{{ specialRoomData ? specialRoomData.text : "" }}</p>
            </div>
            <div class="text-right mr-3">
                <a class="cta main-cta learning-cta" href="/special-rooms/special">{{ specialRoomData? specialRoomData.button:'' }}</a>
            </div>
        </div>

        <div class="lsr-images-section">
            <div
                @click="goto('special')"
                class="lsr-image-container sr-learning-image-container learning-card mb-4 lsr-top-image">
                <div :style="getImage('special')" class="relative-position learning-card-image">
                    <div class="lsr-text-part">
                        <span>{{ specialRoomData? specialRoomData.nav.special.title:'' }}</span>
                    </div>
                </div>
            </div>
            <div class="between-flex flex-wrap">
                <div
                    @click="goto('new')"
                    class="lsr-image-container sr-learning-image-container learning-card lsr-bottom-right-image">
                    <div :style="getImage('new')" class="relative-position learning-card-image">
                        <div class="lsr-text-part">
                            <span>{{ specialRoomData?specialRoomData.nav.new.title:''}}</span>
                        </div>
                    </div>
                </div>
                <div
                    @click="goto('discount')"
                    class="lsr-image-container sr-learning-image-container learning-card lsr-bottom-left-image">
                    <div :style="getImage('discount')" class="relative-position learning-card-image">
                        <div class="lsr-text-part">
                            <span>{{ specialRoomData?specialRoomData.nav.discount.title:''}}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</template>

<script>

export default {
    props: ["specialRoomData"],
    data() {
        return {
            iconPath: sot.iconPath("logo.svg"),
            enterAnimations: sot.enterAnimations,
        };
    },
    methods: {
        goto(type){
            window.location.href = `/special-rooms/${type}`
        },
        getImage(type) {
            let img = this.specialRoomData ? this.specialRoomData.nav[type].image : sot.noImage;
            return `background: url('${img}') no-repeat center center/cover;`;
        }
    },
};
</script>

<style scoped>
.relative-position {
    position: relative;
}

.s-offer-nav-container span:last-child {
    margin-left: 0;
}

.s-offer-nav-container span:hover {
    color: #010101;
}

.s-offer-nav-container {
    border-bottom: 1px solid #dadada;
    padding-bottom: 1rem;
    display: inline-block;
    direction: rtl;
}

.s-o-n-hr {
    position: absolute;
    border-top: 3px solid var(--first-color);
    transition: all 300ms ease-in-out;
    margin: 0;
    padding: 0;
}

.shape-1,
.shape-2 {
    position: absolute;
    width: 20%;
    height: auto;
    z-index: -1;
}

.shape-1 {
    top: -7rem;
    left: -12rem;
}
</style>
