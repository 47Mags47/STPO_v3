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

        CheckBox:       defineAsyncComponent(() => import("../../inputs/CheckBox.vue")),
        StringInput:    defineAsyncComponent(() => import('../../inputs/StringInput.vue')),
        Select:         defineAsyncComponent(() => import('../../inputs/Select.vue')),
        DateInput:      defineAsyncComponent(() => import('../../inputs/DateInput.vue')),
        DateBetween:    defineAsyncComponent(() => import('../../inputs/DateBetweenInput.vue')),
        DatePicker:     defineAsyncComponent(() => import('../../datepicker/DatePicker.vue')),
        SingleSelect:   defineAsyncComponent(() => import('../../inputs/SingleSelect.vue')),
        MultiSelect:    defineAsyncComponent(() => import('../../inputs/MultiSelect.vue')),
        NumberBetween:  defineAsyncComponent(() => import('../../inputs/NumberBetween.vue')),
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
                        'string',
                        'text',
                        'select',
                        'checkbox',
                        'date',
                        'datepicker',
                        'dateBetween',
                        'singleSelect',
                        'multiSelect',
                        'numberBetween'
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
            this.isFilterOpen = !this.isFilterOpen
            // this.fixDropdownPosition()
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
                <div ref="filterForm">
                    <div class="table-filters" :class="{ 'table-visible-show': isFilterOpen }">
                        <div v-for="(filter, index) in filters"
                        @mouseenter="fixDropdownPosition"
                        :class="{
                            'filter-item':
                                filter.type !== 'checkbox'      &&
                                filter.type !== 'singleSelect'  &&
                                filter.type !== 'multiSelect'   &&
                                filter.type !== 'numberBetween'}">
                            <!-- checkbox,  singleSelect, multiSelect, numberBetween-->
                            <template v-if="filter.type === 'checkbox'
                            || filter.type === 'singleSelect'
                            || filter.type === 'multiSelect'
                            || filter.type === 'numberBetween'">
                                <div class="flex items-center gap-2">
                                    <CheckBox       v-if="filter.type === 'checkbox'"       v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                    <SingleSelect   v-if="filter.type === 'singleSelect'"   v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                    <MultiSelect    v-if="filter.type === 'multiSelect'"    v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                    <NumberBetween  v-if="filter.type === 'numberBetween'"  v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>

                                    <span v-if="filter.type === 'checkbox'">{{ filter.name }}</span>
                                </div>
                            </template>

                            <!-- остальные фильтры -->
                            <template v-else>
                                <span>{{ filter.name }}</span>

                                <div class="filter-item-icon">
                                    <Ico type="faChevronDown" />
                                </div>

                                <div class="filter-item-content">
                                    <FormItem
                                    :name="filter.name"
                                    :label="filter.label"
                                    :for="preparePropsFromFilter(filter).name"
                                    orientation="vertical">
                                        <StringInput    v-if="filter.type === 'string'"         v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                        <Select         v-if="filter.type === 'select'"         v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                        <DateInput      v-if="filter.type === 'date'"           v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                        <DatePicker     v-if="filter.type === 'datepicker'"     v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                        <DateBetween    v-if="filter.type === 'dateBetween'"    v-bind="preparePropsFromFilter(filter)" :key="resetKey"/>
                                    </FormItem>
                                </div>
                            </template>
                        </div>
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
                        <div
                        class="filter-btn-item-icon">
                            <Ico type="faChevronDown" />
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
    .container-table-filters
        width: 100%
        display: flex
        flex-direction: column
        gap: 12px

        :deep(.table-filters)
            display: flex
            flex-wrap: wrap
            align-items: center
            gap: 12px

            // скрыто
            opacity: 0
            transform: translateY(-20px)
            max-height: 0
            pointer-events: none

            transition: .4s ease

            &.table-visible-show
                opacity: 1
                transform: translateY(0)
                max-height: 500px
                pointer-events: auto
                transition: .4s ease

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

            .filter-item-content
                display: none
                position: absolute

                top: 100%
                z-index: 1000
                left: 0

                padding: 6px 10px

                width: fit-content
                min-width: 146px
                height: fit-content
                background: white
                filter: drop-shadow(0 8px 8px rgba(0,0,0,0.2))
                border-radius: 8px

                transition: 0.2s ease

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
                        transform: rotate(180deg)

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

<!-- single select /multy , datebetween, checkbox, numberBetween -->
