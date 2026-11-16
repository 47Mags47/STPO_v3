<script>
import { default as BaseInput } from "./Baseinput.vue";

export default {
    components: {
        BaseInput,
    },
    props:{
        // INPUT
        value: {
            type: Boolean,
            deafult: false
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {}
        }
    },
    methods: {
        onChangeHandler(e) {
            this.onChange(e, e.target.checked)
        }
    }
};
</script>

<template>
    <BaseInput
        v-bind="$attrs"
        type="checkbox"
        :checked="value"
        :value
        :on-change="onChangeHandler"
    />
</template>

<style lang="sass" scoped>
.base-input[type="checkbox"]
    appearance: none
    -webkit-appearance: none
    width: 20px
    height: 20px
    border: var(--border)
    border-radius: $input-border-radius
    cursor: pointer
    position: relative
    padding: 0
    flex-shrink: 0

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
</style>
