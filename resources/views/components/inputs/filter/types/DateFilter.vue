<script>
import DatePicker from '../../input/types/datePicker/DatePicker.vue';
import Ico from '../../../Ico.vue';

export default {
    components: {
        DatePicker,
        Ico
    },

    props: {
        isOpen: {
            Type: Boolean,
            default: false
        }
    },

    data() {
        return {
            localIsOpen: null
        }
    },

    // HACK переделать
    methods: {
        inputClickHandler() {
            this.localIsOpen = !this.localIsOpen
            console.log(123)
        },
        closeClickHandler() {
            this.localIsOpen = false
        }
    },

    watch: {
        isOpen: {
            handler(val) {
                this.localIsOpen = val ?? false
            },
            immediate: true
        }
    }
}
</script>

<template>
    <DatePicker
        :is-open="localIsOpen"
        :on-close="closeClickHandler"
        :on-input-click="inputClickHandler"
    />
</template>

<style lang="sass" scoped>
:deep(.date-input-between-wrapper),
:deep(.date-input-wrapper)
    cursor: pointer
    transition: background-color .5s ease
    .custom-date-input
        cursor: pointer
        transition: color .5s ease

    .ico-wrapper
        display: none

    .overlay
        transition: background-color .5s ease

    &:hover
        background-color: var(--button-background-color)

        .custom-date-input
            color: white

        .overlay
            background-color: var(--button-background-color)
</style>
