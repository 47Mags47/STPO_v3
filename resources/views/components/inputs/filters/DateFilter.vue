<script>
import DatePicker from '../datePicker/DatePicker.vue';
import Ico from '../../Ico.vue';

export default {
    components: {
        DatePicker,
        Ico
    },

    props: {
        //  INPUT
        name: {
            type: String,
            default: null
        },
        id: {
            type: String,
            default: null
        },
        value: {
            type: [Object, String],
            default: null
        },

        // OTHER
        isRange: {
            type: Boolean,
            default: false,
        },
    },


    methods: {
        inputClickHandler(data) {
            data.isPopupOpen = !data.isPopupOpen
        }
    }
}
</script>

<template>
    <DatePicker
        :id
        :name
        :value
        :is-range
        :on-input-click="inputClickHandler"
    />
</template>

<style lang="sass" scoped>
:deep(.date-input-between-wrapper)
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
