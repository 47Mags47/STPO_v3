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
            type: Object,
            default: {}
        },

        // OTHER
        isRange: {
            type: Boolean,
            default: false,
        },
    },
}
</script>

<template>
    <DatePicker
        :id
        :name
        :value
        :is-range
    />
</template>

<style lang="sass" scoped>

</style>
