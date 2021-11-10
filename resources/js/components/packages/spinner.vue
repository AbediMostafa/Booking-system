<template>
    <div class="flex-start">
        <span class="d-form-lable">
            {{ loading ? 'درحال بارگزاری':text }}
        </span>
        <div v-if="loading" class="mr-4">
            <div class="spinner"></div>
            <div class="spinner spinner1"></div>
            <div class="spinner spinner2"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["loading", "text"],
};
</script>
