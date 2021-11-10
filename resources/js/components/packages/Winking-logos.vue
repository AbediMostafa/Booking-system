<template>
    <div class="logo-container" :style="logoConatinerBackground">
        <a
            :href="`/rooms?collection=${logo.name}`"
            v-for="logo in logos"
            :key="logo.id"
            :title="logo.name"
            :class="['collection-logo', logo.visible ? '' : 'hide']"
            :style="`background:url(${logo.image}) no-repeat center center/cover`"
        ></a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            logos: [],
        };
    },

    methods: {
        random(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        },
        getCollections() {
            axios.post("/collections/logos").then((Response) => {
                this.logos = Response.data.data;

                if (this.logos.length) {
                    setInterval(() => {
                        let randomNumber = this.random(0, this.logos.length - 1);
                        this.logos[randomNumber].visible = false;

                        setTimeout(() => {
                            this.logos[randomNumber].visible = true;
                        }, 3000);
                    }, 2000);
                }
            });
        },
    },

    computed: {
        logoConatinerBackground() {
            return `background:url(${sot.iconPath(
                "dots.svg"
            )}) no-repeat left bottom/65%`;
        },
    },

    created() {
        this.getCollections();
    },
};
</script>

<style scoped>
.logo-container {
    text-align: center;
    margin-top: 2rem;
}

.hide {
    opacity: 0;
}
</style>
