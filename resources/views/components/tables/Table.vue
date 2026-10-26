<script>
import { Form } from '@inertiajs/vue3';

export default {
    props: {
        caption: {
            type: String,
            default: null,
        },
        onApplyFilters: {
            type: Function,
            default: () => {}
        }
    },

    components: {
        Form,
    },

    computed:{
        currentURL: () => location.href
    },
};
</script>

<template>
    <div class="table-container">
        <div class="table-header">
            <div class="header" v-if="caption !== null">
                <h3>
                    {{ caption }}
                </h3>
            </div>

            <div v-if="'filters' in $slots" class="filters">
                <Form
                    ref="filtersForm"
                    method="GET"
                    :action="currentURL" class="pt-0!"
                    :options="{
                        preserveState: true,
                        onSuccess: onApplyFilters
                    }"
                >
                    <slot name="filters"></slot>
                </Form>
            </div>

            <div v-if="['toolbar-left', 'paginator', 'toolbar-right'].some(slot => $slots[slot])" class="flex w-full">
                <div class="toolbar-left flex-1" v-if="'toolbar-left' in $slots">
                    <Form
                        ref="toolbarLeftRef"
                        method="GET"
                        :action="currentURL"
                        :options="{
                            preserveState: true,
                        }"
                    >
                        <slot name="toolbar-left"></slot>
                    </Form>
                </div>

                <div class="paginator" v-if="'paginator' in $slots">
                    <slot name="paginator"></slot>
                </div>

                <div class="toolbar-right flex-1" v-if="'toolbar-right' in $slots">
                    <slot name="toolbar-right"></slot>
                </div>
            </div>
        </div>

        <div class="table-content">
            <table>
                <colgroup v-if="'colgroup' in $slots">
                    <slot name="colgroup" />
                </colgroup>

                <thead>
                    <template v-if="'thead' in $slots">
                        <slot name="thead" />
                    </template>
                </thead>

                <tbody>
                    <template v-if="'tbody' in $slots">
                        <slot name="tbody" />
                    </template>
                </tbody>
            </table>
        </div>

        <div v-if="['footer', 'pagination'].some(slot => slot in $slots)" class="table-footer">
            <slot v-if="'pagination' in $slots" name="pagination" />
        </div>
    </div>
</template>

<style lang="sass">
.table-container
    width: 100%
    display: flex
    flex-direction: column
    gap: 1rem
    padding: 15px 0
    .table-header
        display: flex
        flex-direction: column
        gap: 10px
        padding: 0 10px
        .header
            font-weight: 600
            color: #1f2937
            line-height: 1.3
        .filters form
            display: flex
            flex-wrap: wrap
            align-items: center
            gap: 32px
        .paginator
            width: 385px
        .toolbar-left
            display: flex
            justify-content: flex-start
            align-items: center
            gap: 1rem
        .toolbar-right
            display: flex
            justify-content: flex-end
            align-items: center
            gap: 1rem

    .table-content
        overflow: hidden

        table
            width: 100%
            border-collapse: collapse
            color: #374151
            tbody
                tr
                    transition: background 0.15s ease
                    color: var(--text-color)

                    &:nth-child(even)
                        background: var(--table-row-background-color)

                    &:hover
                        background: var(--table-row-background-color-hover)
</style>
