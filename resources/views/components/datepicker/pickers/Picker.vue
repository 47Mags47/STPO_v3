<script>
import DayPicker from "./DayPicker.vue";
import MonthPicker from "./MonthPicker.vue";
import YearPicker from "./YearPicker.vue";
import Table from "../../tables/Table.vue";

export default {
    components: {
        DayPicker,
        MonthPicker,
        YearPicker,
        Table,
    },
    props: {
    },
    data() {
        return {

        };
    },
};
</script>

<template>
    <div class="w-full h-full">
        <table class="table-fixed border-collapse w-full">
            <DayPicker />
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
