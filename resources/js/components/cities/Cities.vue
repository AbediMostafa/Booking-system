<template>
    <div class="global-card-container">
        <city-card v-for="city in cities" :city="city" :key="city.id"></city-card>
    </div>
</template>

<script>
import CityCard from '../cards/City-card.vue';
export default {
  components: { CityCard },
    data(){
        return {
            cities:[],
        }
    },
    methods:{
        getCities(){
            axios.post(`/cities`).then(response=>{
                this.cities = response.data.data;
            });
        }
    },
    created(){
        this.getCities();
    }
}
</script>