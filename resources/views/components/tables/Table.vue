<script>
export default {
    props: {
        caption: {
            type: String,
            default: null,
        },
        id: {
            type: String,
            default: null
        },
    },
};
</script>

<template>
    <div class="table-container">
        <div class="table-header">
            <div class="header" v-if="caption !== null">
                <h3> {{ caption }} </h3>
            </div>

            <div v-if="'filters' in $slots" class="filters">
                <slot name="filters"></slot>
            </div>

            <div v-if="['toolbar-left', 'paginator-top', 'toolbar-right'].some(slot => $slots[slot])" class="flex w-full">
                <div class="toolbar-left flex-1" v-if="'toolbar-left' in $slots">
                    <slot name="toolbar-left" />
                </div>

                <div class="paginator" v-if="'paginator-top' in $slots">
                    <slot name="paginator-top" />
                </div>

                <div class="toolbar-right flex-1 " v-if="'toolbar-right' in $slots">
                    <slot name="toolbar-right" />
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

        <div v-if="['footer', 'paginator-bottom'].some(slot => slot in $slots)" class="table-footer">
            <slot v-if="'paginator-bottom' in $slots" name="paginator-bottom" />
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
            width: fit-content
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
            tbody
                tr.row-active
                    td:not([rowspan])
                        background: color-mix(in srgb, var(--table-row-active-background-color) 40%, transparent)
                tr
                    transition: background 0.15s ease
                    &:nth-child(even)
                        background: var(--table-row-background-color)

                    td[rowspan]
                        background: var(--table-row-background-color)
                    &:hover
                        td:not([rowspan])
                            background: var(--table-row-background-color-hover)

</style>
