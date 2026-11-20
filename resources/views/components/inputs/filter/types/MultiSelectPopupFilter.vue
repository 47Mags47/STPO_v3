<script>
import SelectPopup from '../../selectPopup/SelectPopup.vue';

export default {
    components: {
        SelectPopup
    },
}
</script>

<template>
    <SelectPopup type="multiSelectPopup" isFilter/>
</template>

<style lang="sass" scoped>
.multi-select-popup-input-wrapper
    display: flex
    gap: 5px

    height: 35px

    .multi-select-popup-input
        @include input()
        cursor: pointer
        transition: background-color .5s ease
        span
            transition: color .5s ease

        &:hover
            background-color: var(--button-background-color)

            span
                color: white
</style>
