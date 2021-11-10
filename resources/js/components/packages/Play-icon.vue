<template>
  <div class="shi-container">
    <div
      :class="[
        'shi-parent',
        'shi-center',
        size == 'large' ? 'shi-large-parent' : '',
      ]"
    ></div>
    <div
      :class="[
        'shi-child',
        'shi-center',
        size == 'large' ? 'shi-large-child' : '',
      ]"
    ></div>
    <div
      :class="[
        'shi-triangle',
        'shi-center',
        size == 'large' ? 'shi-large-triangle' : '',
      ]"
    ></div>
  </div>
</template>

<script>
export default {
  props: ["size"],
};
</script>

<style scoped>
/* shining chircle animation */

.shi-container {
  position: relative;
  width: 4rem;
  height: 4rem;
  cursor: pointer;
}

.shi-parent {
  border-radius: 50%;
  background: white;
  animation: shi-shine 1500ms cubic-bezier(0.53, 1.33, 0.81, 0.8) infinite;
  position: absolute;
}

.shi-large-parent {
  animation: shi-large-shine 1500ms cubic-bezier(0.53, 1.33, 0.81, 0.8) infinite !important;
}

.shi-center {
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

.shi-child {
  border-radius: 50%;
  width: 2rem;
  height: 2rem;
  background: white;
  position: absolute;
}

.shi-large-child {
  width: 4rem !important;
  height: 4rem !important;
}

.shi-triangle {
  width: 0;
  height: 0;
  border-top: 5px solid transparent;
  border-left: 10px solid #a300cf;
  border-bottom: 5px solid transparent;
  position: relative;
  left: 50%;
}

.shi-large-triangle {
  border-top: 7px solid transparent !important;
  border-left: 14px solid #a300cf !important;
  border-bottom: 7px solid transparent !important;
}

@keyframes shi-shine {
  0% {
    width: 2rem;
    height: 2rem;
    opacity: 1;
  }
  100% {
    width: 3.5rem;
    height: 3.5rem;
    opacity: 0;
  }
}

@keyframes shi-large-shine {
  0% {
    width: 4rem;
    height: 4rem;
    opacity: 1;
  }
  100% {
    width: 6rem;
    height: 6rem;
    opacity: 0;
  }
}
</style>
