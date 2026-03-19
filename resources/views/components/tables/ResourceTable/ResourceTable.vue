<script>
import Table from '../Table.vue';
import { defineAsyncComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import TableRow from '../components/TableRow.vue';
import TableTh from '../components/TableTh.vue';
import TableTd from '../components/TableTd.vue';

export default {
    components: {
        Table,
        TableRow,
        TableTh,
        TableTd,

        CreateButton: defineAsyncComponent(() => import("../buttons/CreateButton.vue")),
        EditButton: defineAsyncComponent(() => import("../buttons/EditButton.vue")),
        ShowButton: defineAsyncComponent(() => import("../buttons/ShowButton.vue")),
        DeleteButton: defineAsyncComponent(() => import("../buttons/DeleteButton.vue")),

        Ico: defineAsyncComponent(() => import("../../Ico.vue")),
        Paginator: defineAsyncComponent(() => import("../../paginations/TablePaginator.vue")),
    },

    props: {
        // Toggles
        hasCreateButton: {
            type: Boolean,
            default: false,
        },
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

        // Actions
        onCreateButtonClick: {
            type: Function,
            default: () => {
                let url = new URL(location.href)
                router.visit(url.origin + url.pathname + '/create')
            }
        },
        onShowButtonClick: {
            type: Function,
            default: (row) => {
                let url = new URL(location.href)
                router.visit(url.origin + url.pathname + '/' + row.id)
            }
        },
        onEditButtonClick: {
            type: Function,
            default: (row) => {
                let url = new URL(location.href)
                router.visit(url.origin + url.pathname + '/' + row.id + '/edit')
            }
        },
        onDeleteButtonClick: {
            type: Function,
            default: (row) => {
                let url = new URL(location.href)
                router.delete(url.origin + url.pathname + '/' + row.id)
            }
        },

        // Data
        collumns: {
            type: Array,
            default: () => []
        },
        data: {
            type: Array,
            default: () => []
        }
    },

    methods: {
        // Handlers
        createButtonClickHandler(e) {
            this.onCreateButtonClick(e);
        },
        showButtonClickHandler(row) {
            this.onShowButtonClick(row);
        },
        editButtonClickHandler(row) {
            this.onEditButtonClick(row);
        },
        deleteButtonClickHandler(row) {
            this.onDeleteButtonClick(row);
        },

        // Check
        checkRowHasShowButton(row){
            return typeof this.hasShowButton === 'function'
                ? this.hasShowButton(row)
                : this.hasShowButton
        },
        checkRowHasEditButton(row){
            return typeof this.hasEditButton === 'function'
                ? this.hasEditButton(row)
                : this.hasEditButton
        },
        checkRowHasDeleteButton(row){
            return typeof this.hasDeleteButton === 'function'
                ? this.hasDeleteButton(row)
                : this.hasDeleteButton
        },
    }
}
</script>

<template>
    <Table class="resource-table">
        <template #toolbar>
            <div class="table-search-container">

            </div>
            <div class="table-actions-container">
                <slot name="actions" />
                <CreateButton @click="createButtonClickHandler" />
            </div>
        </template>

        <template #thead>
            <TableRow>
                <TableTh v-for="column in collumns" v-bind="column">
                    {{ column.title }}
                </TableTh>

                <template v-if="collumns.length > 0 && data.length > 0">
                    <TableTh v-if="hasDeleteButton !== false" button />
                    <TableTh v-if="hasShowButton !== false" button />
                    <TableTh v-if="hasEditButton !== false" button />
                </template>
            </TableRow>
        </template>

        <template #tbody>
            <TableRow v-if="data.length > 0" v-for="row in data">
                <TableTd v-for="collumn in collumns" :value="row[collumn.dataIndex]"/>

                <TableTd v-if="checkRowHasDeleteButton(row)"><DeleteButton @click="() => deleteButtonClickHandler(row)"/></TableTd>
                <TableTd v-if="checkRowHasShowButton(row)"><ShowButton @click="() => showButtonClickHandler(row)"/></TableTd>
                <TableTd v-if="checkRowHasEditButton(row)"><EditButton @click="() => editButtonClickHandler(row)"/></TableTd>
            </TableRow>
            <tr v-else>
                <td :colspan="collumns.length" class="not-data-cell">
                    <Ico type="faDatabase" />
                    <span class="text">Данных нет :(</span>
                </td>
            </tr>
        </template>
    </Table>
</template>

<style lang="sass" scoped>
.resource-table
    .table-header .toolbar
        display: flex
        justify-content: space-between
        .table-search-container
            width: 350px
        .table-actions-container
            .button
                width: 35px
                height: 35px
    .table-content
        .not-data-cell
            display: flex
            flex-direction: column
            gap: 10px
            text-align: center

            padding: 15px
            .ico-container
                font-size: 5rem
            span
                font-size: 1.2rem
                font-weight: bold
    :deep()
        .ico-button .ico-container
            display: flex
            justify-content: center
            align-items: center
</style>
