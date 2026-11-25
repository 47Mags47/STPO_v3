<script>
import TableRow from '../../components/TableRow.vue';
import TableTh from '../../components/TableTh.vue';

export default {
    components: {
        TableRow, TableTh
    },

    props: {
        tableHeadValues: {
            type: Array,
            default: () => []
        }
    }
}
</script>


<template>
    <TableRow>
        <TableTh
            v-for="thValue in tableHeadValues"
            :class="{ 'column-filtered': thValue.isFiltered }"
            v-tooltip="thValue.isFiltered ? 'К таблице применён фильтр по этой колонке' : null"
        >
            {{ thValue.title }} {{ thValue.isFiltered ? '*' : '' }}
        </TableTh>
    </TableRow>
</template>

<style lang="sass" scoped>
.column-filtered
    color: var(--color-blue-400)
</style>
