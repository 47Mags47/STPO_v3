<script>
export default {
    props:{
        name: {
            type: String,
            default: null,
        },
        label: {
            type: String,
            default: null,
        },
        checked: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            isChecked: this.checked
        }
    },
    methods: {
        checkboxClickHandler() {
            this.isChecked = !this.isChecked
        }
    },

    watch: {
        checked(val) {
            this.isChecked = val
        }
    }
}
</script>

<template>
     <div
        class="checkbox-container" :class="{ 'active': isChecked }"
        @click="checkboxClickHandler"
    >
        <span> {{ label }} </span>
    </div>
</template>

<style lang="sass" scoped>
.checkbox-container
    cursor: pointer
    padding: 7px
    transition: .5s ease
    @include input()


    &.active > span, &:hover > span
        color: white

    span
        transition: color .5s ease
        overflow: hidden
        text-overflow: ellipsis
        white-space: nowrap

    &.active
        background-color: var(--button-background-color)

    &:hover
        background-color: var(--button-background-color)

    input
        display: none
</style>
