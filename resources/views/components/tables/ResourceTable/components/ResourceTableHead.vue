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
        <TableTh v-for="thValue in tableHeadValues">
            {{ thValue }}
        </TableTh>
    </TableRow>
</template>
