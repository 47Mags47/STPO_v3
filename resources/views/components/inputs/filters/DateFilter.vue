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
    },

    // HACK переделать
    methods: {
        inputClickHandler(data) {
            data.isPopupOpen = !data.isPopupOpen
        }
    }
}
</script>

<template>
    <DatePicker
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
