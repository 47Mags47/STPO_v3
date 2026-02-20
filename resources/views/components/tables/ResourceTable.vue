<script>
import { defineAsyncComponent } from "vue";
import { router } from "@inertiajs/vue3";
import Table from "./Table.vue";
import TableRow from "./components/TableRow.vue";
import TableTh from "./components/TableTh.vue";
import TableTd from "./components/TableTd.vue";

export default {
    components: {
        Table,
        TableRow,
        TableTh,
        TableTd,
        Ico: defineAsyncComponent(() => import("./../icons/Ico.vue")),
        SearchInput: defineAsyncComponent(
            () => import("./../inputs/SearchInput.vue"),
        ),
        CreateButton: defineAsyncComponent(
            () => import("./buttons/CreateButton.vue"),
        ),
        EditButton: defineAsyncComponent(
            () => import("./buttons/EditButton.vue"),
        ),
        DeleteButton: defineAsyncComponent(
            () => import("./buttons/DeleteButton.vue"),
        ),
        ShowButton: defineAsyncComponent(
            () => import("./buttons/ShowButton.vue"),
        ),
        BasePagination: defineAsyncComponent(
            () => import("../pagination/BasePagination.vue"),
        ),
    },

    props: {
        header: {
            type: String,
            default: "",
        },
        columns: {
            type: Array,
            default: () => [],
        },
        data: {
            type: [Array, Object],
            default: () => [],
        },
        hasSearch: {
            type: Boolean,
            default: false,
        },
        hasDelete: {
            type: [Function, Boolean],
            default: false,
        },
        hasEdit: {
            type: [Function, Boolean],
            default: false,
        },
        hasShow: {
            type: [Function, Boolean],
            default: false,
        },
        OnCreateButtonClick: {
            type: Function,
            default: null,
        },
        OnEditButtonClick: {
            type: Function,
            default: null,
        },
        OnShowButtonClick: {
            type: Function,
            default: null,
        },
        OnDeleteButtonClick: {
            type: Function,
            default: null,
        },
    },

    computed: {
        localHref() {
            let url = new URL(location.href);

            return url.origin + url.pathname;
        },
    },
    data() {
        return {
            rows: "data" in this.data ? this.data.data : this.data,
            meta: "meta" in this.data ? this.data.meta : null,
        };
    },
    watch: {
        data(newData) {
            ((this.rows = "data" in newData ? newData.data : newData),
                (this.meta = "meta" in newData ? newData.meta : null));
        },
    },
    methods: {
        deleteButtonClickHandler(row, e) {
            if (typeof this.OnDeleteButtonClick === "function")
                this.OnDeleteButtonClick(row, e);
            else router.delete(`${this.localHref}/${row.id}`);
        },
        editButtonClickHandler(row, e) {
            if (typeof this.OnEditButtonClick === "function")
                this.OnEditButtonClick(row, e);
            else router.get(`${this.localHref}/${row.id}/edit`);
        },
        showButtonClickHandler(row, e) {
            if (typeof this.OnShowButtonClick === "function")
                this.OnShowButtonClick(row, e);
            else router.get(`${this.localHref}/${row.id}`);
        },
        createButtonClickHandler(e) {
            if (typeof this.OnCreateButtonClick === "function")
                this.OnCreateButtonClick(e);
            else router.get(`${this.localHref}/create`);
        },

        getCellBinds(row, column) {
            return {
                type: column.type ?? "string",
                value: Object.get(row, column.dataIndex),
                rowspan:
                    typeof column.rowspan === "function"
                        ? column.rowspan(row)
                        : (column.rowspan ?? 1),
                colspan:
                    typeof column.colspan === "function"
                        ? column.colspan(row)
                        : (column.colspan ?? 1),
                visible:
                    typeof column.visible === "function"
                        ? column.visible(row)
                        : (column.visible ?? true),
            };
        },
    },
};
</script>

<template>
    <Table class="resource-table" :header="header">
        <template #toolbar>
            <div class="table-options-container">
                <div class="table-search-container">
                    <template v-if="hasSearch">
                        <SearchInput
                            name="filters[search]"
                            placeholder="Найти..."
                        />
                    </template>
                </div>

                <div class="table-actions-container">
                    <slot name="actions" />
                    <CreateButton
                        :onClick="() => createButtonClickHandler(e)"
                    />
                </div>
            </div>
        </template>

        <template #thead>
            <TableRow>
                <TableTh v-for="column in columns" v-bind="column">
                    {{ column.title }}
                </TableTh>

                <template v-if="rows.length > 0">
                    <TableTh v-if="hasDelete !== false" button />
                    <TableTh v-if="hasEdit !== false" button />
                    <TableTh v-if="hasShow !== false" button />
                </template>
            </TableRow>
        </template>

        <template #tbody>
            <TableRow v-for="(row, rowIndex) in rows" :key="row.id ?? rowIndex">
                <TableTd
                    v-for="column in columns"
                    v-bind="getCellBinds(row, column)"
                />

                <TableTd
                    v-if="
                        typeof hasDelete === 'function'
                            ? hasDelete(row)
                            : hasDelete
                    "
                    vertical="center"
                    horizontal="center"
                >
                    <DeleteButton
                        :onClick="(e) => deleteButtonClickHandler(row, e)"
                    />
                </TableTd>

                <TableTd
                    v-if="
                        typeof hasEdit === 'function' ? hasEdit(row) : hasEdit
                    "
                    vertical="center"
                    horizontal="center"
                >
                    <EditButton
                        :onClick="(e) => editButtonClickHandler(row, e)"
                    />
                </TableTd>

                <TableTd
                    v-if="
                        typeof hasShow === 'function' ? hasShow(row) : hasShow
                    "
                    vertical="center"
                    horizontal="center"
                >
                    <ShowButton
                        :onClick="(e) => showButtonClickHandler(row, e)"
                    />
                </TableTd>
            </TableRow>

            <TableRow v-if="rows.length === 0">
                <TableTd
                    :colspan="columns.length > 0 ? columns.length : 1"
                    class="empty"
                    horizontal="center"
                    vertical="center"
                >
                    <Ico type="database-x" />
                    <span class="text">Данных нет :(</span>
                </TableTd>
            </TableRow>
        </template>
        <template #pagination>
            <BasePagination
                :current="meta.current_page"
                :last="meta.last_page"
                position="center:center"
            />
        </template>
    </Table>
</template>

<style lang="sass">
.resource-table
    .table-options-container
        display: grid
        grid-template-areas: 'search actions'
        grid-template-columns: 1fr auto
        gap: 10px
        align-items: center

        .table-search-container
            grid-area: search
            input
                width: 100%

        .table-actions-container
            grid-area: actions
            display: flex
            justify-content: flex-end
            gap: 5px
            button
                min-width: 40px

    .table-content
        tbody
            .empty .table-cell-container
                display: flex
                flex-direction: column
                align-items: center
                justify-content: center
                padding: 50px 0
                gap: 7px
                color: #aaa

                .database-ico
                    color: #aaa
                    width: 50px
                    height: 50px

                .text
                    padding-top: 10px
                    font-size: 1.2rem
                    text-align: center
</style>
