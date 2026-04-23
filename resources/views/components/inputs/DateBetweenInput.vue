<script>
import DatePicker from '../datepicker/DatePicker.vue';

export default {
    components: {
        DatePicker
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
        name: {
            type: String,
            default: ''
        }
    }
}
</script>

<template>

    <div
    class="flex justify-between items-center w-full py-1! h-(--input-height)">
        <div class="flex gap-4 items-center w-fit">
            <span> С </span>
            <DatePicker
            :name="`${name}[dateStart]`"
            :useDayPicker
            :useMonthPicker
            :useYearPicker/>
        </div>

        <div class="h-full w-1 bg-black"></div>

        <div class="flex gap-4 items-center w-fit">
            <span> ПО </span>
            <DatePicker
            :name="`${name}[dateEnd]`"
            :useDayPicker
            :useMonthPicker
            :useYearPicker/>
        </div>
    </div>

</template>

<style lang="sass" scoped>

</style>

