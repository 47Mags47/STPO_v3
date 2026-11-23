<script>
import { defineAsyncComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import Table from '../Table.vue';
import TableRow from '../components/TableRow.vue';
import TableTh from '../components/TableTh.vue';
import TableTd from '../components/TableTd.vue';
import Input from '../../inputs/input/Input.vue';
import Filter from '../../inputs/filter/Filter.vue';
//
import ResourceTableToolbarLeft from './components/ResourceTableToolbarLeft.vue';
import ResourceTableToolbarRight from './components/ResourceTableToolbarRight.vue';
import ResourceTableFilters from './components/ResourceTableFilters.vue';
import ResourceTableBody from './components/ResourceTableBody.vue';
import ResourceTableHead from './components/ResourceTableHead.vue';

export default {
    components: {
        ResourceTableToolbarLeft, ResourceTableToolbarRight, ResourceTableFilters,
        ResourceTableBody, ResourceTableHead,
        //
        Table,
        TableRow,
        TableTh,
        TableTd,
        Input, Filter,

        RowLink:                      defineAsyncComponent(() => import("../ResourceTable/RowLink.vue")),
        FormItem:                     defineAsyncComponent(() => import("../../FormItem.vue")),

        CreateButton:                 defineAsyncComponent(() => import("../buttons/CreateButton.vue")),
        EditButton:                   defineAsyncComponent(() => import("../buttons/EditButton.vue")),
        ShowButton:                   defineAsyncComponent(() => import("../buttons/ShowButton.vue")),
        DeleteButton:                 defineAsyncComponent(() => import("../buttons/DeleteButton.vue")),

        Ico:                          defineAsyncComponent(() => import("../../Ico.vue")),
        Paginator:                    defineAsyncComponent(() => import("../../paginations/TablePaginator.vue")),
        BlueButton:                   defineAsyncComponent(() => import("../../buttons/BlueButton.vue")),
        RedButton:                    defineAsyncComponent(() => import("../../buttons/RedButton.vue")),
    },

    data() {
        return {
            isFilterOpen: false,
            filterResetKey: 0,
            cachedFilters: {},
            filtersStorageKey: `resource-table-filters:${window.location.pathname}`,
            searchInputTimer: null,
        }
    },

    props: {
        id: {
            type: String,
            default: null
        },

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
        hasSearchInput: {
            type: [Boolean, Function],
            default: true
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
        onSearchInput: {
            type: Function,
            default: null
        },

        // Data
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
            validator(value) {
                let hasInvalidType = value.filter((input) => {
                    return ![
                        'checkbox',
                        'singleSelect',
                        'multiSelect',
                        'multiSelectPopup',
                        'date'
                    ].includes(input.type);
                });

                if (hasInvalidType.length !== 0) {
                    hasInvalidType.forEach((input) => {
                        throw new Error(
                            `Недействительный тип "${input.type}"!`,
                        );
                    });

                    return false;
                }

                return true;
            },
        },
        channels: {
            type: Array,
            default: () => []
        },

        //Other
        rowLinks: {
            type: Array,
            default: [],
        },
        rowClasses: {
            type: [Array, String, Function, Object],
            default: null
        },
        actions: {
            type: Array,
            default: [],
        },
    },

    methods: {
        // FILTERS
        resetFilters() {
            localStorage.removeItem(this.filtersStorageKey)
            this.cachedFilters = {}

            // Увеличиваем ключ - этот ключ у каждого компонента фильтров и он конкатенируется с filter.name
            // Это нужно для сброса, чтобы создавался новый компонент (при изменении ключа компонент пересоздаётся),
            // Оставался фильтр открытым, а значения компонентов сбрасывались
            this.filterResetKey++

            router.get(
                window.location.pathname,
                {},
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },

        toggleFilterVisible() {
            this.isFilterOpen = !this.isFilterOpen;
        },
        restoreFilters() {
            try {
                const savedFilters = localStorage.getItem(this.filtersStorageKey);

                if (savedFilters) {
                    this.cachedFilters = JSON.parse(savedFilters);
                }
            } catch (error) {
                console.error('Не удалось восстановить фильтры:', error);
                this.cachedFilters = {};
            }
        },
        applyFilters() {
            const form = this.$refs.table.$refs.filtersForm.$el;
            const formData = new FormData(form);

            const result = {};

            this.filters.forEach(({ name, type }) => {
                let value

                switch (type) {
                    case 'multiSelect':
                        value = formData
                            .getAll(`filters[${name}][]`)
                            .map(Number)
                        break

                    case 'date':
                        value = {
                            from: formData.get(`filters[${name}]_from`) ?? '',
                            to: formData.get(`filters[${name}]_to`) ?? '',
                        };
                        break;

                    case 'singleSelect':
                        value = formData.get(`filters[${name}]`)
                        break

                    case 'checkbox':
                        value = formData.has(`filters[${name}]`)
                        break

                    case 'selectPopup':
                        value = formData.get(`filters[${name}]`)
                        break

                    case 'multiSelectPopup':
                        value = formData
                            .getAll(`filters[${name}][]`)
                            .map(Number)
                        break

                    default:
                        return
                }

                result[type] ??= { value: {} };
                result[type].value[name] = value;
            });

            result.urlParams = Object.fromEntries(
                new URLSearchParams(window.location.search)
            );

            this.cachedFilters = result;

            localStorage.setItem(
                this.filtersStorageKey,
                JSON.stringify(result)
            );
        },

        // HANDLERS
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
        inputHandler(e) {
            clearTimeout(this.searchInputTimer);

            this.searchInputTimer = setTimeout(
                this.onSearchInput !== null
                    ? () => this.onSearchInput(e)
                    : () => { router.get(window.location.pathname,
                        {
                            search: e.target.value
                        },
                        {
                            preserveState: true,
                        }
                    );
            }, 1000)
        },
    },

    async mounted() {
        // Берём из localStorage значения фильтров пихуем в компоненты и кликаем (отправляем на сервер)
        this.restoreFilters()

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

    beforeUnmount() {
        clearTimeout(this.searchInputTimer);
    }
}
</script>

<template>
    <Table
        ref="table" class="resource-table"
        :on-apply-filters="applyFilters"
        :id
    >
        <template #toolbar-left>
            <slot name="toolbar-left" />
            <ResourceTableToolbarLeft
                :id
                :has-search-input
                :on-search="inputHandler"
            />
        </template>

        <template #paginator-top>
            <div class="table-paginate-container">
                <Paginator
                    v-if="meta.last_page > 1"
                    v-bind="meta"
                />
            </div>
        </template>

        <template #toolbar-right>
            <slot name="toolbar-right" />
            <ResourceTableToolbarRight
                :has-create-button
                :on-create="createButtonClickHandler"
            />
        </template>

        <template v-if="filters.length !== 0" #filters>
            <ResourceTableFilters
                :is-filter-open
                :filters
                :cached-filters
                :filter-reset-key
                :on-open="toggleFilterVisible"
                :on-reset="resetFilters"
            />
        </template>

        <template #colgroup>
            <slot name="colgroup" />
            <col v-for="column in columns" :width="column.width ?? 'auto'"/>

            <col v-if="hasDeleteButton && data.length > 0" width="60px" />
            <col v-if="hasShowButton && data.length > 0" width="60px" />
            <col v-if="hasEditButton && data.length > 0" width="60px" />
        </template>

        <template #thead>
            <slot name="thead" />
            <ResourceTableHead
                :data
                :row-links
                :has-show-button
                :has-edit-button
                :has-delete-button
            />
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
                :on-show="showButtonClickHandler"
                :on-edit="editButtonClickHandler"
                :on-delete="deleteButtonClickHandler"
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
