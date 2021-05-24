<template>
  <div class="star-container">
    <div class="c-empty-stars"></div>
    <div class="c-filled-stars" :style="starStyle"></div>
  </div>
</template>

<script>
export default {
    props:['score'],
    computed:{
        starStyle(){
            return `width:${this.score}%`
        }
    }
};
</script>