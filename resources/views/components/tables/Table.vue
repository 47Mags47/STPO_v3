<script>
export default {
    props: {
        header: {
            type: String,
            default: null,
        },
    },
};
</script>

<template>
    <div class="table-container">
        <div class="table-header">
            <div class="header" v-if="!(header === null)">
                <h3>
                    {{ header }}
                </h3>
            </div>

            <div class="toolbar" v-if="'toolbar' in $slots">
                <slot name="toolbar"></slot>
            </div>
        </div>

        <div class="table-content">
            <table>
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

        <div class="table-footer">
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
    padding: 1.25rem
    border-radius: 12px

    .header
        font-weight: 600
        color: #1f2937
        line-height: 1.3

        .toolbar
            display: flex
            justify-content: space-between
            align-items: center
            gap: 1rem

    .table-content
        border: $table-border
        border-radius: 10px
        overflow: hidden

        table
            width: 100%
            border-collapse: separate
            border-spacing: 0
            color: #374151
            min-width: 600px
            tbody
                tr
                    transition: background 0.15s ease

                    &:nth-child(even)
                        background: #f9fafb

                    &:hover
                        background: #eef2ff

            tbody tr:last-child td
                border-bottom: none
</style>
