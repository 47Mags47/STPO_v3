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
    display: flex
    cursor: pointer
    padding: 7px
    transition: .5s ease
    @include input()

    &.active
        background-color: $button-background
        color: white

    &:hover
        background-color: $button-background
        color: white

    input
        display: none
</style>
