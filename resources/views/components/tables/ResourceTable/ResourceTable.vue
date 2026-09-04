<script>
import { h } from 'vue';
import { defineAsyncComponent } from 'vue';
import { router } from '@inertiajs/vue3';

import Table from '../Table.vue';
import TableRow from '../components/TableRow.vue';
import TableTh from '../components/TableTh.vue';
import TableTd from '../components/TableTd.vue';

import FormItem from '../../FormItem.vue';

export default {
    components: {
        Table,
        TableRow,
        TableTh,
        TableTd,

        RowLink:        defineAsyncComponent(() => import("../ResourceTable/RowLink.vue")),
        FormItem:       defineAsyncComponent(() => import("../../FormItem.vue")),

        CreateButton:   defineAsyncComponent(() => import("../buttons/CreateButton.vue")),
        EditButton:     defineAsyncComponent(() => import("../buttons/EditButton.vue")),
        ShowButton:     defineAsyncComponent(() => import("../buttons/ShowButton.vue")),
        DeleteButton:   defineAsyncComponent(() => import("../buttons/DeleteButton.vue")),

        Ico:            defineAsyncComponent(() => import("../../Ico.vue")),
        Paginator:      defineAsyncComponent(() => import("../../paginations/TablePaginator.vue")),
        BlueButton:     defineAsyncComponent(() => import("../../buttons/BlueButton.vue")),
        RedButton:      defineAsyncComponent(() => import("../../buttons/RedButton.vue")),

        Checkbox:       defineAsyncComponent(() => import("../../inputs/filters/Checkbox.vue")),
        SingleSelect:   defineAsyncComponent(() => import('../../inputs/filters/SingleSelect.vue')),
        MultiSelect:    defineAsyncComponent(() => import('../../inputs/filters/MultiSelect.vue')),
        NumberBetween:  defineAsyncComponent(() => import('../../inputs/filters/NumberBetween.vue')),
        DateFilter:     defineAsyncComponent(() => import('../../inputs/filters/DateFilter.vue')),
    },

    data() {
        return {
            isFilterOpen: false,
        }
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
        filters: {
            type: Array,
            default: () => [],
            validator(value) {
                let hasInvalidType = value.filter((input) => {
                    return ![
                        'checkbox',
                        'datepicker',
                        'singleSelect',
                        'multiSelect',
                        'numberBetween',
                        'dateFilter'
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
            type: [Array, String, Function],
            default: null
        },

        actions: {
            type: Array,
            default: [],
        }
    },

    methods: {
        resetFilters() {
            router.get(
                window.location.pathname,
                {},
                {
                    preserveState: false,
                    replace: true
                }
            );
        },
        // Если контент фильтра выходит за пределы экрана справа -> смещаем влево
        fixDropdownPosition(event) {
            const el =
                event.currentTarget.querySelector(
                    '.filter-item-content'
                );

            if (!el) return;

            requestAnimationFrame(() => {
                el.style.left = '0';
                el.style.right = 'auto';

                const rect = el.getBoundingClientRect();

                if (rect.right > window.innerWidth - 12) {
                    el.style.left = 'auto';
                    el.style.right = '0';
                }
            });
        },

        preparePropsFromFilter(filter) {
            const { type, label, ...rest } = filter;

            rest.name = `filters[${rest.name}]`

            return rest;
        },
        toggleFilterVisible() {
            this.isFilterOpen = !this.isFilterOpen;
        },

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

        // Classes
        getRowClasses(row) {
            if (this.rowClasses === null) return

            if (typeof this.rowClasses === 'string')
                return this.rowClasses

            if (Array.isArray(this.rowClasses))
                return this.rowClasses.join(' ')

            if (typeof this.rowClasses === 'function') {
                let returned = this.rowClasses(row)

                if ( typeof returned !== 'string' )
                    console.error('rowClasses должен возвращать строку. Возвращаемое значение: ', returned)

                return returned
            }
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
        },
        getCellRowspan(row, column, index) {
            if (typeof column.rowspan === 'function') {
                return column.rowspan(row, index, this.data)
            }

            return column.rowspan
        },
    },

    mounted() {
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
    }
}
</script>

<template>
    <Table class="resource-table">
        <template v-if="filters.length !== 0" #filters>
            <div class="container-table-filters">
                <div ref="filtersRef" class="table-filters" :class="{ 'opened': isFilterOpen }">
                    <div class="min-w-[calc(100%/5-12px)] max-w-[calc(100%/5-12px)] flex-1" v-for="filter in filters">
                        <MultiSelect    v-if="filter.type === 'multiSelect'"    v-bind="preparePropsFromFilter(filter)" :label="filter.label" />
                        <SingleSelect   v-if="filter.type === 'singleSelect'"   v-bind="preparePropsFromFilter(filter)" :label="filter.label" />
                        <Checkbox       v-if="filter.type === 'checkbox'"       v-bind="preparePropsFromFilter(filter)" :label="filter.label" />
                        <NumberBetween  v-if="filter.type === 'numberBetween'"  v-bind="preparePropsFromFilter(filter)" :label="filter.label" />
                        <DateFilter     v-if="filter.type === 'dateFilter'"     v-bind="preparePropsFromFilter(filter)" :label="filter.label" />
                    </div>
                </div>
                <div class="filter-btns">
                    <button type="button" @click="resetFilters" class="filter-btn"  :class="{ filterShow: isFilterOpen }">
                        Сбросить
                    </button>
                    <button class="filter-btn"  :class="{ filterShow: isFilterOpen }">
                        Применить
                    </button>
                    <button type="button"   class="filter-showbtn"
                    :class="{ active: isFilterOpen }"
                    @click="toggleFilterVisible">
                        <span> фильтры </span>
                        <div class="filter-btn-item-icon">
                            <Ico type="chevron-down" class="text-white" />
                        </div>
                    </button>
                </div>
            </div>
        </template>

        <template #toolbar>
            <div class="table-search-container">

            </div>
            <div class="table-paginate-container">
                <Paginator v-if="meta.last_page > 1" v-bind="meta" />
            </div>
            <div class="table-actions-container">
                <slot name="actions" />
                <div class="resource-table-actions-container">
                    <template v-for="action in actions">
                        <BlueButton v-if="action.color === undefined || action.color === 'blue'" :onClick="action.onClick">
                            <Ico :type="action.ico" />
                        </BlueButton>
                        <RedButton v-if="action.color === 'red'" :onClick="action.onClick">
                            <Ico :type="action.ico" />
                        </RedButton>
                    </template>
                    <CreateButton v-if="hasCreateButton" @click="createButtonClickHandler" />
                </div>
            </div>
        </template>

        <template #colgroup>
            <slot name="colgroup" />
            <col v-for="column in collumns" :width="column.width ?? 'auto'"/>

            <col v-if="hasDeleteButton && data.length > 0" width="60px" />
            <col v-if="hasShowButton && data.length > 0" width="60px" />
            <col v-if="hasEditButton && data.length > 0" width="60px" />
        </template>

        <template #thead>
            <slot name="thead" />
            <TableRow>
                <template v-for="column in collumns">
                    <TableTh v-if="column.colspan !== 0" v-bind="{ width: column.width, colspan: column.headerColspan }">
                        <span> {{ column.title }} </span>
                    </TableTh>
                </template>

                <template v-if="collumns.length > 0 && data.length > 0">
                    <TableTh v-if="hasDeleteButton !== false" button />
                    <TableTh v-if="hasShowButton !== false" button />
                    <TableTh v-if="hasEditButton !== false" button />
                </template>

                <TableTh v-for="link in rowLinks" button />
            </TableRow>
        </template>

        <template #tbody>
            <template v-if="data.length > 0">
                <TableRow
                    v-for="(row, index) in data"
                    :key="row.id ?? index"
                    :class="getRowClasses(row)"
                >
                    <template v-for="collumn in collumns" :key="collumn.dataIndex">
                        <TableTd
                            v-if="
                                checkCellVisible(row, collumn)
                                && getCellRowspan(row, collumn, index) !== 0
                            "
                            v-bind="{
                                ...collumn,
                                row,
                                value: getCellValue(row, collumn),
                                rowspan: getCellRowspan(row, collumn, index)
                            }"
                        />
                    </template>

                    <TableTd v-if="checkRowHasDeleteButton(row)">
                        <DeleteButton @click="() => deleteButtonClickHandler(row)" />
                    </TableTd>

                    <TableTd v-if="checkRowHasShowButton(row)">
                        <ShowButton @click="() => showButtonClickHandler(row)" />
                    </TableTd>

                    <TableTd v-if="checkRowHasEditButton(row)">
                        <EditButton @click="() => editButtonClickHandler(row)" />
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
                    :colspan="collumns.length + rowLinks.length"
                    vertical="center"
                    horizontal="center"
                    class="not-data-cell"
                >
                    <Ico
                        class="text-(--text-color)! h-[148px]!"
                        type="database"
                    />

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
    .container-table-filters
        width: 100%
        display: flex
        flex-direction: column
        z-index: 100

        :deep(.table-filters)
            display: flex
            max-height: 0
            flex-wrap: wrap
            align-items: center
            gap: 12px

            padding-bottom: 0
            overflow: hidden
            opacity: 0

            transition: max-height .5s ease, padding-bottom .5s ease, opacity .5s ease

            &.opened
                overflow: visible
                opacity: 1
                max-height: 170px
                padding-bottom: 8px

        :deep(.filter-item)
            position: relative
            display: flex
            align-items: center

            height: 32px
            gap: 6px
            padding: 6px 10px
            border-radius: 14px
            background: whitesmoke
            transition: .2s ease

            &:hover
                background: lightgray
                cursor: pointer
                color: black
                .filter-item-icon
                    color: black
                    transform: rotate(180deg)
                .filter-item-content
                    display: flex

            .filter-item-icon
                color: lightgray
                height: 100%
                width: 24px
                transform: rotate(0deg)
                transition: .2s ease

        .filter-btns
            display: flex
            justify-content: end
            gap: 4px

            :deep(.filter-btn)
                height: 35px
                padding: 8px
                border-radius: 8px
                background: var(--button-background-color)
                color: white
                font-weight: bold
                align-self: flex-end
                transition: .2s ease

                opacity: 0
                visibility: hidden

                &.filterShow
                    opacity: 1
                    visibility: visible

                &:hover
                    background: var(--button-background-color-hover)
                    cursor: pointer

            :deep(.filter-showbtn)
                display: flex
                justify-content: center
                gap: 6px
                height: 35px
                padding: 8px
                border-radius: 8px
                background: var(--button-background-color)
                color: white
                align-self: flex-end
                transition: .2s ease
                font-weight: bold

                &:hover
                    background: var(--button-background-color-hover)
                    cursor: pointer

                &.active
                    .filter-btn-item-icon
                        transform: rotate(540deg)

                .filter-btn-item-icon
                    color: lightgray
                    height: 100%
                    width: fit-content
                    transition: .2s ease
                    transform: rotate(0deg)
    :deep()
        .table-header
            padding: 0 15px
        .toolbar
            .table-actions-container
                display: flex
                gap: 10px
                .button
                    padding: 9px
                    width: 35px
                    height: 35px

        .table-content
            .not-data-cell .table-cell-container
                height: 250px
                padding: 35px 0px

                display: flex
                flex-direction: column
                gap: 25px

                font-size: 1.2rem
            .table-button-cell .table-cell-container .button
                width: 35px
                height: 30px
            .table-file-status-cell .table-cell-container
                padding: 5px
</style>
