<template>
    <div>
        <div class="global-card-container">
            <city-card v-for="city in cities" :city="city" :key="city.id"></city-card>
        </div>
        <div class="pagination-container">
            <div
                class="pagination-btns"
                v-for="(pagination, key) in pagination"
                :key="key"
                @click="getCities(pagination.url)"
                :class="[pagination.active ? 'active-pagination' : '']"
            >
                {{ pagination.label }}
            </div>
        </div>
    </div>
</template>

<script>
import CityCard from '../cards/City-card.vue';

export default {
    components: {CityCard},
    data() {
        return {
            cities: [],
            pagination: [],
        }
    },
    methods: {
        getCities(url = `/cities`) {
            axios.post(url).then(response => {
                this.cities = response.data.data;
                this.pagination = response.data.meta.links;
            });
        }
    },
    created() {
        this.getCities();
    }
}
</script>
