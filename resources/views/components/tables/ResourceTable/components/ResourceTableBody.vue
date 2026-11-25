<script>
import TableRow from '../../components/TableRow.vue';
import TableTd from '../../components/TableTd.vue';
import RowLink from '../RowLink.vue';
import ShowButton from '../../buttons/ShowButton.vue';
import DeleteButton from '../../buttons/DeleteButton.vue';
import EditButton from '../../buttons/EditButton.vue';
import Ico from '../../../Ico.vue';
import { h } from 'vue';

export default {
    components: {
        RowLink,
        TableRow, TableTd,
        ShowButton, DeleteButton, EditButton,
        Ico,
    },
    props: {
        data: {
            type: Array,
            default: () => []
        },
        columns: {
            type: Array,
            default: () => []
        },
        rowLinks: {
            type: Array,
            default: () => [],
        },
        rowClasses: {
            type: [Array, String, Function, Object],
            default: null
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

        // HANDLERS
        onShow: {
            type: Function,
            default: () => {}
        },
        onDelete: {
            type: Function,
            default: () => {}
        },
        onEdit: {
            type: Function,
            default: () => {}
        },
        onRowClick: {
            type: Function,
            default: null
        },
    },

    methods: {
        // CHECKS
        checkCellVisible(row, column) {
            let visible = column.visible ?? true

            return typeof visible === 'function'
                ? visible(row)
                : visible ?? true
        },
        getCellRowspan(row, column, index) {
            if (typeof column.rowspan === 'function') {
                return column.rowspan(row, index, this.data)
            }

            return column.rowspan
        },
        getCellValue(row, column){
            if('render' in column) {
                let renderData = column.render(row)

                let props = {
                    ...renderData.props,
                    onClick: (e) => renderData.props.onClick ? renderData.props.onClick(e) : null
                }

                return () => h(renderData.component ?? 'div', {...props});
            }

            if(typeof column.value == 'function')
                return column.value(row)

            return Object.get(row, column.dataIndex)
        },

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

        // GETTERS
        getRowClasses(row) {
            if (this.rowClasses === null)
                return

            if (typeof this.rowClasses === 'string')
                return this.rowClasses

            if (typeof this.rowClasses === 'object')
                return Object.keys().filter((key) => this.rowClasses[key] === true).join(' ')

            if (Array.isArray(this.rowClasses))
                return this.rowClasses.join(' ')

            if (typeof this.rowClasses === 'function') {
                let returned = this.rowClasses(row)

                if ( typeof returned !== 'string' )
                    console.error('rowClasses должен возвращать строку. Возвращаемое значение: ', returned)

                return returned
            }
        },
    }
};
</script>

<template>
    <template v-if="data.length > 0">
        <TableRow
            v-for="(row, index) in data"
            :key="row.id ?? index"
            :class="getRowClasses(row)"
            @click="(e) => onRowClick ? onRowClick(e, row) : null"
        >
            <template v-for="column in columns" :key="column.dataIndex">
                <TableTd
                    v-if="
                        checkCellVisible(row, column)
                        && getCellRowspan(row, column, index) !== 0
                    "
                    v-bind="{
                        ...column,
                        row,
                        value: getCellValue(row, column),
                        rowspan: getCellRowspan(row, column, index)
                    }"
                />
            </template>

            <TableTd v-if="checkRowHasDeleteButton(row)">
                <DeleteButton @click="() => onDelete(row)" />
            </TableTd>

            <TableTd v-if="checkRowHasShowButton(row)">
                <ShowButton @click="() => onShow(row)" />
            </TableTd>

            <TableTd v-if="checkRowHasEditButton(row)">
                <EditButton @click="() => onEdit(row)" />
            </TableTd>

            <RowLink
                v-for="link in rowLinks"
                :key="link.name ?? link"
                v-bind="{ ...link, row }"
            />
        </TableRow>
    </template>

    <tr v-else>
        <TableTd
            :colspan="columns.length + rowLinks.length"
            vertical="center"
            horizontal="center"
            class="not-data-cell"
        >
            <Ico
                class="h-[148px]!"
                type="database"
            />

            <span class="text">Данных нет :(</span>
        </TableTd>
    </tr>
</template>

<style lang="sass" scoped>
.table-content
    .not-data-cell .table-cell-container
        height: 250px
        padding: 35px 0px

        display: flex
        flex-direction: column
        gap: 25px

        font-size: 1.2rem

    .table-file-status-cell .table-cell-container
        padding: 5px
</style>
