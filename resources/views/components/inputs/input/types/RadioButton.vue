<script>
import BaseInput from "../Baseinput.vue";

export default {
    components: {
        BaseInput,
    },
};
</script>

<template>
    <BaseInput type="radio" />
</template>

<style lang="sass" scoped>
.base-input[type="radio"]
        appearance: none
        -webkit-appearance: none
        width: 11px
        height: 11px
        border: var(--border)
        border-radius: 100%
        cursor: pointer
        position: relative
        padding: 0
        flex-shrink: 0

        &:checked
            background-color: var(--radio-on-background)

.checkbox-wrapper
    display: flex
    align-items: center
</style>
