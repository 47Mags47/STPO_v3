<script>
export default {
    props: {
        type: {
            type: String,
        }
    }
};
</script>

<template>
    <div class="ico-container">
        <i :class="['fa-solid', `fa-${type}`]"></i>
    </div>
</template>

<style lang="sass" scoped>
.ico-container
    width: 100%
    height: 100%

    position: relative

    display: flex

    overflow: hidden
    svg
        width: 100%
        height: 100%
</style>
