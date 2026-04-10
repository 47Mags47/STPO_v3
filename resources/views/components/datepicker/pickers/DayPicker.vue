<script>
import Cell from './Cell/Cell.vue'
import TableRow from '@components/tables/components/TableRow.vue';

export default {
    inject: ['baseDate'],
    components: {
        Cell,
        TableRow
    },
    props: {
    },
    data() {
        return {
        }
    },
    computed: {
        calendarGrid() {
            const startOfMonth = this.baseDate.startOf('month');
            let startOfGrid = startOfMonth.startOf('week');

            const days = [];
            for (let i = 0; i < 42; i++) {
                days.push(startOfGrid.plus({ days: i }));
            }

            const weeks = [];
            for (let i = 0; i < days.length; i += 7) {
                weeks.push(days.slice(i, i + 7));
            }
            return weeks;
        }
    }
}

</script>


<template>
    <TableRow class="bg-cyan-100" v-for="(week, wIndex) in calendarGrid">
        <Cell
        v-for="day in week"
        position="center-center"
        class="w-full items-center border border-black w-[calc(100% / 7)])"
        :class="{
            'bg-gray-300': day.month === baseDate.month ? false : true,
            'text-red-500': [6, 7].includes(day.weekday)
        }"
        :item="day.day"/>
    </TableRow>
</template>

<style lang="scss" scoped>

</style>
