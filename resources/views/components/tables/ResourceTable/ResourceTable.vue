<script>
import Table from '../Table.vue';
import { defineAsyncComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import TableRow from '../components/TableRow.vue';
import TableTh from '../components/TableTh.vue';
import TableTd from '../components/TableTd.vue';
import { h } from 'vue';

import FormItem from '../../FormItem.vue';

export default {
    components: {
        Table,
        TableRow,
        TableTh,
        TableTd,

        FormItem,

        CreateButton:   defineAsyncComponent(() => import("../buttons/CreateButton.vue")),
        EditButton:     defineAsyncComponent(() => import("../buttons/EditButton.vue")),
        ShowButton:     defineAsyncComponent(() => import("../buttons/ShowButton.vue")),
        DeleteButton:   defineAsyncComponent(() => import("../buttons/DeleteButton.vue")),

        Ico:            defineAsyncComponent(() => import("../../Ico.vue")),
        Paginator:      defineAsyncComponent(() => import("../../paginations/TablePaginator.vue")),
        BlueButton:     defineAsyncComponent(() => import("../../buttons/BlueButton.vue")),

        Checkbox:       defineAsyncComponent(() => import("../../inputs/filters/Checkbox.vue")),
        SingleSelect:   defineAsyncComponent(() => import('../../inputs/filters/SingleSelect.vue')),
        MultiSelect:    defineAsyncComponent(() => import('../../inputs/filters/MultiSelect.vue')),
        NumberBetween:  defineAsyncComponent(() => import('../../inputs/filters/NumberBetween.vue')),
        DateFilter:     defineAsyncComponent(() => import('../../inputs/filters/DateFilter.vue')),
    },

    data() {
        return {
            hoveredFilterIndex: null,
            isFilterOpen: false,
            resetKey: 0,
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

        //Other
        rowLinks: {
            type: Array,
            default: [],
        },

        channels: {
            type: Array,
            default: []
        },

        rowClasses: {
            type: [Array, String, Function],
            default: null
        }
    },

    methods: {
        resetFilters() {
            this.resetKey++;

            router.get(
                window.location.pathname,
                {},
                {
                    preserveState: true,
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
            const el = this.$refs.filtersRef;

            if (!el) return;

            this.isFilterOpen = !this.isFilterOpen;

            if (this.isFilterOpen) {
                el.classList.add('opened');

                // во время анимации скрываем overflow
                el.style.overflow = 'hidden';
                el.style.maxHeight = `${el.scrollHeight}px`;

                // после анимации открываем overflow
                setTimeout(() => {
                    if (this.isFilterOpen) {
                        el.style.overflow = 'visible';
                        el.style.maxHeight = 'none';
                    }
                }, 400);
            } else {
                // перед закрытием снова скрываем overflow
                el.style.overflow = 'hidden';

                if (el.style.maxHeight === 'none') {
                    el.style.maxHeight = `${el.scrollHeight}px`;
                }

                requestAnimationFrame(() => {
                    el.style.maxHeight = '0px';
                });

                setTimeout(() => {
                    el.classList.remove('opened');
                }, 400);
            }
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

        statusColor(row, collumn) {
            if (collumn.title?.toLowerCase() !== 'статус') return

            const statusName = this.getCellValue(row, collumn).toLowerCase()
            if (statusName === "новая")             return "text-blue-700"
            if (statusName === "в работе")          return "text-yellow-800"
            if (statusName === "ожидание ответа")   return "text-indigo-700"
            if (statusName === "закрыта")           return "text-green-700"
            if (statusName === "в доработке")       return "text-orange-700"
        }
    },

    mounted() {
        this.channels.forEach((channel) => {
            Echo.channel(channel. name)
                .listen(channel.event, channel.onEvent)
        })
    }
}
</script>

<template>
    <Table class="resource-table">
        <template #colgroup>
            <col v-for="column in collumns" :width="column.width ?? 'auto'"/>
        </template>

        <template #filters>
            <div class="container-table-filters">
                <div ref="filtersRef" class="table-filters" :class="{ 'opened': isFilterOpen }">
                    <div class="w-[260px]" v-for="filter in filters">
                        <MultiSelect    v-if="filter.type === 'multiSelect'"
                        :name="preparePropsFromFilter(filter).name"     :label="filter.label"      :options="filter.options"/>
                        <SingleSelect   v-if="filter.type === 'singleSelect'"
                        :name="preparePropsFromFilter(filter).name"     :label="filter.label"      :options="filter.options"/>
                        <Checkbox       v-if="filter.type === 'checkbox'"
                        :name="preparePropsFromFilter(filter).name"     :label="filter.label" />
                        <NumberBetween  v-if="filter.type === 'numberBetween'"
                        :name="preparePropsFromFilter(filter).name"     :label="filter.label" />
                        <DateFilter     v-if="filter.type === 'dateFilter'"
                        :name="preparePropsFromFilter(filter).name"     :label="filter.label"       :range-mode="filter.rangeMode"/>
                    </div>
                </div>
                <div class="filter-btns">
                    <button type="button"   class="filter-btn"  :class="{ filterShow: isFilterOpen }" @click="resetFilters">
                        Сбросить
                    </button>
                    <button                 class="filter-btn"  :class="{ filterShow: isFilterOpen }">
                        Применить
                    </button>
                    <button type="button"   class="filter-showbtn"
                    :class="{ active: isFilterOpen }"
                    @click="toggleFilterVisible">
                        фильтры
                        <div class="filter-btn-item-icon">
                            <Ico type="faChevronDown" class="" />
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
                <CreateButton v-if="hasCreateButton" @click="createButtonClickHandler" />
            </div>
        </template>

        <template #thead>
            <TableRow>

                <template v-for="column in collumns">
                    <TableTh v-if="column.colspan !== 0" v-bind="{ width: column.width, colspan: column.headerColspan }">
                        {{ column.title }}
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
            <TableRow v-if="data.length > 0" v-for="row in data" :class="getRowClasses(row)" >
                <template v-for="collumn in collumns">
                    <TableTd
                        v-if="checkCellVisible(row, collumn)"
                        v-bind="{...collumn, row, value: getCellValue(row, collumn)}"
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
.test
    height: 25px
.resource-table
    .container-table-filters
        width: 100%
        display: flex
        flex-direction: column
        gap: 12px
        z-index: 100

        :deep(.table-filters)
            display: flex
            flex-wrap: wrap
            align-items: center
            gap: 12px

            overflow: hidden
            max-height: 0
            pointer-events: none

            padding-bottom: 8px

            opacity: 0

            transition: max-height .5s ease, opacity .5s ease

            &.opened
                opacity: 1
                transform: translateY(0)
                pointer-events: auto
                box-shadow: 0px 7px 4px -8px gray

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
                height: fit-content
                padding: 4px 10px
                border-radius: 8px
                background: $blue-button-background
                color: white
                align-self: flex-end
                transition: .2s ease

                opacity: 0
                visibility: hidden

                &.filterShow
                    opacity: 1
                    visibility: visible

                &:hover
                    background: $blue-button-backgroun-hover
                    cursor: pointer

            :deep(.filter-showbtn)
                display: flex
                gap: 6px
                height: fit-content
                padding: 4px 10px
                border-radius: 8px
                background: $blue-button-background
                color: white
                align-self: flex-end
                transition: .2s ease

                &:hover
                    background: $blue-button-backgroun-hover
                    cursor: pointer

                &.active
                    .filter-btn-item-icon
                        transform: rotate(540deg)

                .filter-btn-item-icon
                    color: lightgray
                    height: 100%
                    width: 14px
                    transition: .2s ease
                    transform: rotate(0deg)


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
