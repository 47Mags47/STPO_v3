<script>
import { DateTime } from "luxon";
import { defineAsyncComponent } from "vue";

export default {
    components:{
        CellRender: defineAsyncComponent(() => import("./CellRender.vue")),
    },

    props: {
        row: {
            type: Object,
            default: {}
        },
        render: {
            type: Function,
            default: null
        },
        dataIndex: {
            type: String,
            default: ''
        },

        // Content
        type: {
            type: String,
            default: 'string',
            validator(value) {
                return [
                    'string',
                    'date',
                    'datetime',
                    'render',
                    'file-status'
                ].includes(value);
            },
        },
        value: {
            type: [String, Number, Function],
            default: "",
        },
        format: {
            type: String,
            default: null
        },

        // Style
        colspan: {
            type: [Number, Function],
            default: null,
        },
        rowspan: {
            type: [Number, Function],
            default: null,
        },
        cellClasses: {
            type: [String, Array, Function],
            default: null
        },
        position: {
            type: String,
            default: "center-left",
            validator(val) {
                return [
                    "top-left",
                    "top-center",
                    "top-right",

                    "center-left",
                    "center-center",
                    "center-right",

                    "bottom-left",
                    "bottom-center",
                    "bottom-right",
                ].includes(val);
            },
        },
        visible: {
            type: [Boolean, Function],
            default: true,
        },
    },

    computed: {
        normalizedValue() {
            if (this.type == 'string')
                return this.value;

            if (this.type == 'date')
                return this.value !== null
                    ? DateTime.fromISO(this.value).toFormat(this.format ?? 'dd.MM.yyyy')
                    : ''

            if (this.type == 'datetime')
                return this.value !== null
                    ? DateTime.fromISO(this.value).toFormat(this.format ?? 'dd.MM.yyyy HH:mm')
                    : ''

            if(this.type == 'file-status'){
                console.log(this.row)
                if(this.row.file.status.code){

                }

                return '<h1>test<h1>'
            }
        },
    },

    methods: {
        getCellClasses() {
            if (this.cellClasses === null) return

            if (typeof this.cellClasses === 'string')
                return this.cellClasses

            if (Array.isArray(this.cellClasses))
                return this.cellClasses.join(' ')

            if (typeof this.cellClasses === 'function') {
                let returned = this.cellClasses(this.value, this.row)

                if ( typeof returned !== 'string' )
                    console.error('cellClasses должен возвращать строку. Возвращаемое значение: ', returned)

                return returned
            }
        },
    }
};
</script>

<template>
    <td v-if="visible"
        :colspan
        :class="getCellClasses()"
        :rowspan
    >
        <div :class="['table-cell-container', position]">
            <template v-if="'default' in $slots">
                <slot />
            </template>
            <template v-else-if="typeof value === 'function'">
                <CellRender :how="value"/>
            </template>
            <template v-else>
                <p v-html="normalizedValue" />
            </template>
        </div>
    </td>
</template>

<style lang="sass" scoped>
td
    border: var(--border)
    position: relative
    p
        color: inherit
.table-cell-container
    width: 100%
    height: 100%

    padding: 7px 10px

    display: flex
    &.top-left
        justify-content: flex-start
        align-items: center
    &.top-center
        justify-content: center
        align-items: center
    &.top-right
        justify-content: flex-end
        align-items: center
    &.center-left
        justify-content: flex-start
        align-items: center
    &.center-center
        justify-content: center
        align-items: center
    &.center-right
        justify-content: flex-end
        align-items: center
    &.bottom-left
        justify-content: flex-start
        align-items: center
    &.bottom-center
        justify-content: center
        align-items: center
    &.bottom-right
        justify-content: flex-end
        align-items: center
</style>
