<script>
export default {
    props: {
        type: {
            type: String,
        }
    },

    computed: {
        getType () {
            return this.type
        }
    }
};
</script>

<template>
    <div class="ico-container">
        <i :class="['fa-solid', `fa-${getType}`]"></i>
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
