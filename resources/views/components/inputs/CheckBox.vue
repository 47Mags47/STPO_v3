<script>
import { default as BaseInput } from "./Baseinput.vue";

export default {
    components: {
        BaseInput,
    },
};
</script>

<template>
    <BaseInput type="checkbox" />
</template>

<style lang="sass" scoped>
.base-input[type="checkbox"]
        appearance: none
        -webkit-appearance: none
        width: 20px !important
        height: 20px !important
        border: var(--border)
        border-radius: $input-border-radius
        cursor: pointer
        position: relative
        padding: 0

        &:checked
            background-color: var(--button-background-color)

        &:checked::after
            content: ""
            position: absolute
            left: 50%
            top: 45%
            width: 6px
            height: 12px
            border: solid #fff
            border-width: 0 2px 2px 0
            transform: translate(-50%, -50%) rotate(45deg)

.checkbox-wrapper
    display: flex
    align-items: center
</style>
