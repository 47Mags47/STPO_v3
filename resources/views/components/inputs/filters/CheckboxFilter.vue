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

    },
    data() {
        return {
            isChecked: null
        }
    },
    methods: {
        checkboxClickHandler(e) {
            this.isChecked = !this.isChecked
        }
    },

    watch: {
        checked: {
            handler(val) {
                this.isChecked = val
            },
            immediate: true,
        },
    }
}
</script>

<template>
     <label
        class="checkbox-container" :class="{ 'active': isChecked }"
        @click="checkboxClickHandler"
    >
        <Checkbox hidden v-bind="$attrs" :checked="isChecked"/>
        <span> {{ placeholder }} </span>
    </label>
</template>

<style lang="sass" scoped>
.checkbox-container
    display: flex
    cursor: pointer
    padding: 7px
    transition: .5s ease
    @include input()

    &.active
        background-color: var(--button-background-color)
        span
            transition: .5s ease
            color: white

    &:hover
        background-color: var(--button-background-color)
        span
            transition: .5s ease
            color: white

    input
        display: none
</style>
