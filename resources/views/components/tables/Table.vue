<script>
import { Form } from '@inertiajs/vue3';

export default {
    props: {
        caption: {
            type: String,
            default: null,
        },
    },

    components: {
        Form,
    },

    computed:{
        currrentURL: () => location.href
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
                <Form method="GET" :action="currrentURL" class="pt-0!">
                    <slot name="filters"></slot>
                </Form>
            </div>

            <div class="toolbar" v-if="'toolbar' in $slots">
                <slot name="toolbar"></slot>
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
        padding: 0 10px
        .header
            font-weight: 600
            color: #1f2937
            line-height: 1.3
        .filters form
            padding: 10px 0px
            display: flex
            flex-wrap: wrap
            align-items: center
            gap: 32px
        .toolbar
            display: flex
            justify-content: space-between
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
