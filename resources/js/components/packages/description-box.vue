<template>
  <div class="rs-box-shadow rsd-image-text-container">
    <div class="rsd-descripton-text">
      <h4 class="rsd-h">
            <small>داستان اتاق فرار</small>
          {{room.name}}
      </h4>
      <p class="rsd-p">{{ room.description }}</p>
      <div class="rsd-cta-collection-container">
        <a class="rsd-cta" @click="sendComment">
          <span class="lc-read-more">ارسال نظر</span>
          <img :src="iconPath('white-pencil.svg')" class="card-right-arrow" />
        </a>

        <div class="rsd-collection">
          <div class="rsd-collection-name">
            {{ room.collection ? room.collection.name : "" }}
          </div>
          <div
            class="rsd-collection-image"
            :style="imageAsBackground(collectionImg)"
          ></div>
        </div>
      </div>
    </div>
    <div
      class="rsd-image-container"
      :style="imageAsBackground(room.image)"
    ></div>

      <div class="short-description" v-if="room.shortDescription">
          <img src="/images/icons/blue-grey-check.svg" class="ml-2 header-room-icons">
          <span>
          {{room.shortDescription}}
          </span>
      </div>
  </div>
</template>

<script>
export default {
  props: ["room"],

  data(){
    return {
      displayModal:false
    }
  },
  methods: {
    sendComment(){
      axios.post('/auth-check').then(response=>{
        location.href = response.data? `/insert-comment/${this.room.id}`:`/phone-check/${this.room.id}`;
      });
    },
    iconPath(icon) {
      return sot.iconPath(icon);
    },

    imageAsBackground(image) {
      let img = image ? image : sot.noImage;

      return `background: url(${img}) no-repeat center/cover`;
    },
  },

  computed: {
    collectionImg() {
      return this.room.collection ? this.room.collection.image : "";
    },
  },
};
</script>
