<script>
import TableRow from '@components/tables/components/TableRow.vue';
import TableTd from '@components/tables/components/TableTd.vue';

export default {
    components: {
        TableRow,
        TableTd,
    },
    data() {
        return {
            daysOfWeek: [
                'пн',
                'вт',
                'ср',
                'чт',
                'пт',
                'сб',
                'вс',
            ]
        }
    },
}

</script>


<template>
    <div class="w-full border-t">
        <TableRow class="grid grid-cols-7">
            <tableTd class="w-full items-center"
            position="center-center"
            :value="dayOfWeek"
            v-for="dayOfWeek in daysOfWeek" />
        </TableRow>
    </div>
</template>

<style lang="scss" scoped>

</style>
