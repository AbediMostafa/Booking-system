<template>
  <div
    :class="['comment-modal-container', displayModal ? 'visible-modal' : '']"
  >
    <a @click="displayModal = false"
      ><img :src="iconPath('gradiant-cancle.svg')" class="comment-cancle-icon"
    /></a>
    <div class="comment-modal">
      <comment :comment="currentComment"></comment>
      {{ answers }}
    </div>
  </div>
</template>

<script>
export default {};
</script>