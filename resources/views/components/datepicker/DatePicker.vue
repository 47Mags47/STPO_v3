<script>
import DayPicker from './pickers/DayPicker.vue';

export default {
    components: {
        // HeaderDatePicker,
        // Picker
        DayPicker,
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
    },
    computed: {
        pickerList() {
            let list = [];

            if (this.useDayPicker)
                list.push("day");

            if (this.useMonthPicker)
                list.push("month");

            if (this.useYearPicker)
                list.push("year");

            return list;
        },

        // currentPicker(){
        //     return pickerList
        // }
    },
};
</script>

<template>
    <div class="date-picker-container">
        <DayPicker v-if="pickerList.includes('day')"/>
        <!-- <MonthPicker v-if="getCurrentPicker() =='month'" />
        <YearPicker v-if="getCurrentPicker() =='year'" /> -->
    </div>
</template>

<style lang="sass" scoped>
.date-picker-container
    width: 276px
    height: fit-content
</style>
