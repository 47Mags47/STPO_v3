<script>
import DateBetween from './DateBetween.vue';
import SingleDate from './SingleDate.vue';

export default {
    components: {
        DateBetween,
        SingleDate
    },
    props: {
        useDayPicker: {
            type: Boolean,
            default: true,
        },
        useMonthPicker: {
            type: Boolean,
            default: true,
        },
        useYearPicker: {
            type: Boolean,
            default: true,
        },
        rangeMode: {
            type: Boolean,
            default: false,
        },
        value: {
            type: [String, Object],
            default: null,
        },
        name: {
            type: String,
            default: null
        }
    },
    data() {
        return {
        }
    },
    methods: {
    },
};
</script>

<template>
    <div class="relative size-full">
        <DateBetween v-if="rangeMode"
        :use-day-picker
        :use-month-picker
        :use-year-picker
        :value
        :name/>

        <SingleDate v-else
        :use-day-picker
        :use-month-picker
        :use-year-picker
        :value
        :name/>
    </div>
</template>

<style lang="sass" scoped>
.date-picker-container
    position: absolute
    width: 250px
    height: 340px


.ico
    position: absolute
    right: 8px
    top: 0
    width: 16px
    cursor: pointer

    &:hover
        color: gray

    &:active
        color: black

</style>
