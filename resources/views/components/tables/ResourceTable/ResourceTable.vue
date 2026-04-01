<script>
import Table from '../Table.vue';
import { defineAsyncComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import TableRow from '../components/TableRow.vue';
import TableTh from '../components/TableTh.vue';
import TableTd from '../components/TableTd.vue';
import { h } from 'vue';

export default {
    components: {
        Table,
        TableRow,
        TableTh,
        TableTd,

        CreateButton:   defineAsyncComponent(() => import("../buttons/CreateButton.vue")),
        EditButton:     defineAsyncComponent(() => import("../buttons/EditButton.vue")),
        ShowButton:     defineAsyncComponent(() => import("../buttons/ShowButton.vue")),
        DeleteButton:   defineAsyncComponent(() => import("../buttons/DeleteButton.vue")),

        Ico:            defineAsyncComponent(() => import("../../Ico.vue")),
        Paginator:      defineAsyncComponent(() => import("../../paginations/TablePaginator.vue")),
        BlueButton:     defineAsyncComponent(() => import("../../buttons/BlueButton.vue")),
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
        },
        meta: {
            type: Object,
            default: () => ({ current_page: 1, last_page: 1 })
        },

        //Other
        rowLinks: {
            type: Array,
            default: [],
        },
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
        checkRowHasShowButton(row) {
            return typeof this.hasShowButton === 'function'
                ? this.hasShowButton(row)
                : this.hasShowButton
        },
        checkRowHasEditButton(row) {
            return typeof this.hasEditButton === 'function'
                ? this.hasEditButton(row)
                : this.hasEditButton
        },
        checkRowHasDeleteButton(row) {
            return typeof this.hasDeleteButton === 'function'
                ? this.hasDeleteButton(row)
                : this.hasDeleteButton
        },

        checkCellVisible(row, collumn) {
            let visible = collumn.visible ?? true

            return typeof visible === 'function'
                ? visible(row)
                : visible ?? true
        },

        // Math
        getCellValue(row, collumn){
            if('render' in collumn) {
                let renderData = collumn.render(row)

                let props = {
                    ...renderData.props,
                    onClick: () => renderData.props.onClick(row)
                }

                return () => h(renderData.component ?? 'div', {...props});
            }

            if(typeof collumn.value == 'function')
                return collumn.value(row)

            return Object.get(row, collumn.dataIndex)
        }
    }
}
</script>

<template>
    <Table class="resource-table">
        <template #colgroup>
            <col v-for="column in collumns" :width="column.width ?? 'auto'"/>
        </template>

        <template #toolbar>
            <div class="table-search-container">

            </div>
            <div class="table-paginate-container">
                <Paginator v-if="meta.last_page > 1" v-bind="meta" />
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

                <TableTh v-for="link in rowLinks" button />
            </TableRow>
        </template>

        <template #tbody>
            <TableRow v-if="data.length > 0" v-for="row in data" >
                <template v-for="collumn in collumns">
                    <TableTd
                        v-if="checkCellVisible(row, collumn)"
                        v-bind="{...collumn, value: getCellValue(row, collumn)}"
                    />
                </template>

                <TableTd v-if="checkRowHasDeleteButton(row)"><DeleteButton @click="() => deleteButtonClickHandler(row)" /></TableTd>
                <TableTd v-if="checkRowHasShowButton(row)"><ShowButton @click="() => showButtonClickHandler(row)" /></TableTd>
                <TableTd v-if="checkRowHasEditButton(row)"><EditButton @click="() => editButtonClickHandler(row)" /></TableTd>

                <TableTd v-for="link in rowLinks">
                    <BlueButton :onclick="() => link.onClick(row)" class="ico-button">
                        <Ico :type="link.ico" />
                    </BlueButton>
                </TableTd>
            </TableRow>
            <tr v-else>
                <TableTd :colspan="collumns.length + rowLinks.length" vertical="center" horizontal="center" class="not-data-cell">
                    <Ico type="faDatabase" />
                    <span class="text">Данных нет :(</span>
                </TableTd>
            </tr>
        </template>

        <template v-if="meta.last_page > 1" #pagination>
            <Paginator v-bind="meta" />
        </template>
    </Table>
</template>

<style lang="sass" scoped>
.resource-table
    :deep()
        .table-header
            padding: 0 15px
        .table-content .not-data-cell .table-cell-container
            height: 250px
            padding: 35px 0px

            display: flex
            flex-direction: column
            gap: 25px

            font-size: 1.2rem
</style>
