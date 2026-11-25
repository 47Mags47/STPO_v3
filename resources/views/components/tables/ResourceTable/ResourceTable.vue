<script>
import { defineAsyncComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import Table from '../Table.vue';
import ResourceTableToolbarLeft from './components/ResourceTableToolbarLeft.vue';
import ResourceTableToolbarRight from './components/ResourceTableToolbarRight.vue';
import ResourceTableFilters from './components/ResourceTableFilters.vue';
import ResourceTableBody from './components/ResourceTableBody.vue';
import ResourceTableHead from './components/ResourceTableHead.vue';

export default {
    components: {
        Table,
        ResourceTableToolbarLeft,
        ResourceTableToolbarRight,
        ResourceTableFilters,
        ResourceTableBody,
        ResourceTableHead,

        Paginator:                    defineAsyncComponent(() => import("../../paginations/TablePaginator.vue")),
    },

    props: {
        // DEFAULT
        id: {
            type: String,
            default: null
        },

        // BUTTONS
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
        hasSearchInput: {
            type: [Boolean, Function],
            default: true
        },

        // HANDLERS
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
        onSearchInput: {
            type: Function,
            default: null
        },
        onRowClick: {
            type: Function,
            default: () => {}
        },

        // DATA
        columns: {
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
        filters: {
            type: Array,
            default: () => [],
        },
        channels: {
            type: Array,
            default: () => []
        },

        // OTHER
        actions: {
            type: Array,
            default: () => [],
        },
        rowLinks: {
            type: Array,
            default: () => [],
        },
        rowClasses: {
            type: [Array, String, Function, Object],
            default: null
        },
    },

    data() {
        return {
            filtersStorageKey: `resource-table-filters:${window.location.pathname}`,
            cachedFilters: {}
        }
    },

    methods: {
        cachedFiltersChangeHandler(v) {
            this.cachedFilters = v
        }
    },

    computed: {
        tableHeadValues() {
            let values = []

            this.columns.forEach(column => {
                values.push({
                    title: column.title,
                    isFiltered: column.filterName
                        ? Object.entries(this.cachedFilters.urlParams ?? {}).some(
                            ([key, value]) =>
                                key.startsWith(`filters[${column.filterName}]`) && value !== ''
                        )
                        : false
                })
            })

            // Кнопки
            values.push(...[
                this.hasShowButton,
                this.hasEditButton,
                this.hasDeleteButton,
            ].filter(Boolean).map(() => ({
                title: '',
                isFiltered: false
            })))

            // RowLinks
            values.push(...Array.from(
                { length: this.rowLinks.length },
                () => ({ title: '', isFiltered: false })
            ))

            return values
        }
    },

    async mounted() {
        this.channels.forEach(function(channel){
            if(typeof channel !== 'object'){
                console.error('Неверный формат канала');
                return;
            }

            if(channel.name === undefined){
                console.error('Не задан name канала')
                return
            }

            if(channel.event === undefined){
                console.error('Не задан event канала')
                return
            }

            if(channel.onEvent === undefined){
                console.error('Не задан onEvent канала')
                return
            }

            Echo.channel(channel.name)
                .listen(channel.event, channel.onEvent)
        })
    },
}
</script>

<template>
    <Table class="resource-table">
        <template #toolbar-left>
            <slot name="toolbar-left" />
            <ResourceTableToolbarLeft
                :id
                :has-search-input
                :on-search-input
            />
        </template>

        <template v-if="meta.last_page > 1" #paginator-top>
            <Paginator v-bind="meta" />
        </template>

        <template #toolbar-right>
            <slot name="toolbar-right" />
            <ResourceTableToolbarRight
                :has-create-button
                :on-create="onCreateButtonClick"
            />
        </template>

        <template v-if="filters.length > 0" #filters>
            <ResourceTableFilters
                :filters
                :filters-storage-key
                :cached-filters
                :on-cached-filters-change="cachedFiltersChangeHandler"
            />
        </template>

        <template #colgroup>
            <col v-for="column in columns"  :width="column.width ?? 'auto'"/>
            <col v-for="link in rowLinks"   :width="link.width ?? 'auto'"/>
            <col v-for="action in actions"  :width="action.width ?? 'auto'"/>

            <col v-if="hasDeleteButton  && data.length > 0" width="60px" />
            <col v-if="hasShowButton    && data.length > 0" width="60px" />
            <col v-if="hasEditButton    && data.length > 0" width="60px" />
        </template>

        <template v-if="data.length > 0" #thead>
            <ResourceTableHead :table-head-values />
        </template>

        <template #tbody>
            <ResourceTableBody
                :data
                :columns
                :row-links
                :row-classes
                :has-show-button
                :has-edit-button
                :has-delete-button
                :on-show="onShowButtonClick"
                :on-edit="onEditButtonClick"
                :on-delete="onDeleteButtonClick"
                :on-row-click
            />
        </template>

        <template v-if="meta.last_page > 1" #paginator-bottom>
            <Paginator v-bind="meta" />
        </template>
    </Table>
</template>

<style lang="sass" scoped>
.resource-table
    :deep()
        .table-header
            padding: 0 15px

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
