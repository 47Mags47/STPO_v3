<script>
import Input from '../../../inputs/input/Input.vue';
import Filter from '../../../inputs/filter/Filter.vue';
import Ico from '../../../Ico.vue';

export default {
    components: {
        Input, Filter,
        Ico
    },
    props: {
        isFilterOpen: {
            type: Boolean,
            default: false
        },
        filters: {
            type: Array,
            default: ([])
        },
        cachedFilters: {
            type: Object,
            default: {}
        },
        filterResetKey: {
            type: Number,
            default: 0
        },

        // HANDLERS
        onOpen: {
            type: Function,
            default: () => {}
        },
        onReset: {
            type: Function,
            default: () => {}
        }
    },

    methods: {
        preparePropsFromFilter(filter) {
            const { type, label, ...rest } = filter;

            rest.value = this.cachedFilters[type]?.value?.[rest.name] ?? rest.value
            rest.name = `filters[${rest.name}]`

            return rest;
        },
    }
};
</script>

<template>
    <div class="table-filters-wrapper">
        <div
            class="table-filters-collapse"
            :class="{ 'opened': isFilterOpen }"
        >
            <div ref="filtersRef" class="table-filters" :class="{ 'opened': isFilterOpen }">
                <div class="min-w-[calc(100%/5-12px)] max-w-[calc(100%/5-12px)] flex-1" v-for="filter in filters" :key="`${filter.name}-${filterResetKey}`">
                    <Filter   :type="filter.type"   v-bind="preparePropsFromFilter(filter)" :label="filter.label" />
                </div>
            </div>
        </div>
        <div class="filter-btns">
            <button type="button" @click="onReset" class="filter-btn"  :class="{ filterShow: isFilterOpen }">
                Сбросить
            </button>
            <button class="filter-btn" ref="filtersBtnApply" :class="{ filterShow: isFilterOpen }">
                Применить
            </button>
            <button type="button" class="filter-showbtn"
            :class="{ active: isFilterOpen }"
            @click="onOpen">
                <span> фильтры </span>
                <div class="filter-btn-item-icon">
                    <Ico type="chevron-down" />
                </div>
            </button>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.table-filters-wrapper
    width: 100%
    height: 100%

    .table-filters-collapse
        display: grid
        grid-template-rows: 0fr
        transition: grid-template-rows .3s ease
        overflow: hidden

        &.opened
            grid-template-rows: 1fr
            overflow: visible

    :deep(.table-filters)
        display: flex
        flex-wrap: wrap
        align-items: center
        gap: 12px

        min-height: 0
        opacity: 0
        padding-bottom: 0

        transition: opacity .3s ease, padding-bottom .3s ease, padding-top .3s ease

    .table-filters-collapse.opened
        :deep(.table-filters)
            opacity: 1
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
</style>
