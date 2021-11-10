<template>
    <div class="d-item-container">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                همه اتاق های من
            </h3>
        </div>

        <div class="d-cards-container">
            <my-complicated-room-card v-for="room in rooms" :key="room.id" :room="room"></my-complicated-room-card>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import MyComplicatedRoomCard from '../../cards/MyComplicated-room-card.vue';

export default {
    components: {
        MyComplicatedRoomCard,
        Comment,
    },
    data() {
        return {
            rooms:[],
            paginations:[]
        };
    },
    methods: {
        getEntities(url) {
            axios
                .get(url)
                .then((response) => {
                    this.rooms = response.data.data;

                    cc(this.rooms);
                });
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },

    created() {
        this.getEntities("my-rooms");
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
