<script>
import DayPicker from "./DayPicker.vue";
import MonthPicker from "./MonthPicker.vue";
import YearPicker from "./YearPicker.vue";
import { DateTime } from "luxon";
import Table from "../../tables/Table.vue";

export default {
    components: {
        DayPicker,
        MonthPicker,
        YearPicker,
        Table,
    },
    data() {
        return {
            dateNow: DateTime.now(),
            startOfMonth: DateTime.now().startOf("month"),
            endOfMonth: DateTime.now().endOf("month"),

            days: Array.from({ length: 30 }, (v, i) => i + 1),
        };
    },
};
</script>

<template>
    <div class="w-full h-full">
        <table class="table-fixed border-collapse w-full">
            <DayPicker :days="days" />
        </table>
    </div>
</template>

<style lang="sass" scoped>
// .picker-container
//     width: 100%
//     height: 100%
//     table
//         width: 100%
//         table-layout: fixed
//         border-collapse: collapse
//         td
//             width: calc(100% / 7)
</style>
