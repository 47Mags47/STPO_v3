<script>
import Input from '../../../inputs/input/Input.vue';
import Filter from '../../../inputs/filter/Filter.vue';
import Ico from '../../../Ico.vue';
import { Form, router } from '@inertiajs/vue3';

export default {
    components: {
        Input,
        Filter,
        Form,
        Ico
    },
    props: {
        filters: {
            type: Array,
            default: () => []
        },
        cachedFilters: {
            type: Object,
            default: {}
        },
        filtersStorageKey: {
            type: String,
            default: `resource-table-filters:${window.location.pathname}`
        },
        onCachedFiltersChange: {
            type: Function,
            default: () => {}
        }
    },

    data() {
        return {
            isFilterOpen: false,
            filterResetKey: 0,
        }
    },

    methods: {
        preparePropsFromFilter(filter) {
            const { type, label, ...rest } = filter;

            rest.value = this.cachedFilters[type]?.value?.[rest.name] ?? rest.value
            rest.name = `filters[${rest.name}]`

            return rest;
        },

        restoreFilters() {
            try {
                const savedFilters = localStorage.getItem(this.filtersStorageKey);

                if (savedFilters) {
                    // this.cachedFilters = JSON.parse(savedFilters);
                    this.onCachedFiltersChange(JSON.parse(savedFilters))
                }
            } catch (error) {
                console.error('Не удалось восстановить фильтры:', error);
                // this.cachedFilters = {};
                this.onCachedFiltersChange({})
            }
        },

        // HANDLERS
        applyFiltersHandler() {
            const form = this.$refs.filtersForm.$el;
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

            // this.cachedFilters = result;
            this.onCachedFiltersChange(result)

            localStorage.setItem(
                this.filtersStorageKey,
                JSON.stringify(result)
            );
        },
        resetFiltersHandler() {
            localStorage.removeItem(this.filtersStorageKey)
            // this.cachedFilters = {}
            this.onCachedFiltersChange({})

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
        openFiltersHandler() {
            this.isFilterOpen = !this.isFilterOpen;
        },
    },

    computed:{
        currentURL: () => location.href
    },

    mounted() {
        this.restoreFilters()
    }
};
</script>

<template>
    <Form
        ref="filtersForm"
        method="GET"
        :action="currentURL" class="pt-0!"
        :options="{
            preserveState: true,
            onSuccess: applyFiltersHandler
        }"
    >
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
                <button type="button" @click="resetFiltersHandler" class="filter-btn"  :class="{ filterShow: isFilterOpen }">
                    Сбросить
                </button>
                <button class="filter-btn" ref="filtersBtnApply" :class="{ filterShow: isFilterOpen }">
                    Применить
                </button>
                <button type="button" class="filter-showbtn"
                :class="{ active: isFilterOpen }"
                @click="openFiltersHandler">
                    <span> фильтры </span>
                    <div class="filter-btn-item-icon">
                        <Ico type="chevron-down" />
                    </div>
                </button>
            </div>
        </div>
    </Form>
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
                height: 100%
                width: fit-content
                transition: .2s ease
                transform: rotate(0deg)
</style>
