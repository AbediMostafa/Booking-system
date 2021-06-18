<template>
  <div class="rs-scores rs-box-shadow">
    <div class="rs-rate-sentence">
      <span class="rs-from5">5/</span>
      <span class="rs-rate-avg">{{ room.rates.rate_average }}</span>
      <span class="rs-rate-count">
        از مجموع {{ room.rates.rate_count }} امتیاز
      </span>
    </div>
  </div>
</template>

<script>

export default({
    props:['rates'],
    
    data() {
        return{

        }
        
    },
})
</script>
