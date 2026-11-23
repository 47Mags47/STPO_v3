<script>
import TableRow from '../../components/TableRow.vue';
import TableTh from '../../components/TableTh.vue';

export default {
    components: {
        TableRow, TableTh
    },

    props: {
        data: {
            type: Array,
            default: () => []
        },
        columns: {
            type: Array,
            default: ([])
        },
        rowLinks: {
            type: Array,
            default: () => [],
        },

        //
        hasShowButton: {
            type: [Boolean, Function],
            default: false,
        },
        hasEditButton: {
            type: [Boolean, Function],
            default: false,
        },
        hasDeleteButton: {
            type: [Boolean, Function],
            default: false,
        },
    }
}
</script>


<template>
    <TableRow>
        <template v-for="column in columns">
            <TableTh v-if="column.colspan !== 0" v-bind="{ width: column.width, colspan: column.headerColspan }">
                <span> {{ column.title }} </span>
            </TableTh>
        </template>

        <template v-if="columns.length > 0 && data.length > 0">
            <TableTh v-if="!hasDeleteButton" button />
            <TableTh v-if="!hasShowButton"   button />
            <TableTh v-if="!hasEditButton"   button />
        </template>

        <TableTh v-for="link in rowLinks" button />
    </TableRow>
</template>
