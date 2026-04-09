<script>
import { DateTime } from 'luxon';
import Cell from './Cell/Cell.vue'
import TableRow from '@components/tables/components/TableRow.vue';

export default {
    components: {
        Cell,
        TableRow
    },
    props: {
        days: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {

        }
    },
}

</script>


<template>
    <TableRow class="bg-cyan-100" v-for="week in 5">
        <Cell
        position="center-center"
        class="w-full items-center border w-[calc(100% / 7)])"
        v-for="day in 7"
        :item="day"/>
    </TableRow>
</template>

<style lang="scss" scoped>

</style>
