<script>
import Checkbox from '../input/Checkbox.vue';

export default {
    components: {
        Checkbox
    },

    props:{
        name: {
            type: String,
            default: null,
        },
        checked: {
            type: Boolean,
            default: false
        },
        placeholder: {
            type: String,
            default: null,
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {}
        }
    },
    data() {
        return {
            isChecked: null
        }
    },
    methods: {
        checkboxClickHandler(e, v) {
            this.isChecked = !this.isChecked

            this.onChange(e, v)
        }
    },

    watch: {
        checked: {
            handler(val) {
                this.isChecked = val ?? false
            },
            immediate: true,
        },
    }
}
</script>

<template>
    <label class="checkbox-container" :class="{ 'active': isChecked }">
        <Checkbox hidden v-bind="$attrs" :on-change="checkboxClickHandler" :checked="isChecked"/>
        <span> {{ placeholder }} </span>
    </label>
</template>

<style lang="sass" scoped>
.checkbox-container
    display: flex
    cursor: pointer
    padding: 7px
    transition: background-color .5s ease
    span
        transition: color .5s ease

    @include input()

    &.active
        background-color: var(--button-background-color)
        span
            color: white

    &:hover
        background-color: var(--button-background-color)
        span
            color: white
</style>
