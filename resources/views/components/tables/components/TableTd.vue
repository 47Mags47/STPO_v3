<script>
import { DateTime } from "luxon";

export default {
    props: {
        visible: {
            type: Boolean,
            default: true,
        },
        type: {
            type: String,
            validator(value) {
                return ["string", "date"].includes(value);
            },
        },
        vertical: {
            type: String,
            default: "top",
        },
        horizontal: {
            type: String,
            default: "left",
        },
        colspan: {
            type: [Number, Function],
            default: null,
        },
        rowspan: {
            type: [Number, Function],
            default: null,
        },
        value: {
            type: String,
            default: "",
        },
        class: {
            type: [String, Object],
            default: null,
        },
    },

    computed: {
        styles() {
            let styles = {};

            let positions = {
                vertical: {
                    top: "flex-start",
                    center: "center",
                    bottom: "flex-end",
                },
                horizontal: {
                    left: "flex-start",
                    center: "center",
                    right: "flex-end",
                },
            };

            styles["align-items"] = positions.vertical[this.vertical];
            styles["justify-content"] = positions.horizontal[this.horizontal];

            return styles;
        },
        normalizeValue() {
            if (this.type == "string") return this.value;
            if (this.type == "date")
                return DateTime.fromISO(this.value).toFormat("dd.MM.yyyy");
        },
        getClasses() {
            let classes = {};

            if (typeof this.class === "object") classes = this.class;

            if (typeof this.class === "string") classes[this.class] = true;

            return classes;
        },
    },
};
</script>

<template>
    <td v-if="visible" :colspan :rowspan :class="getClasses" v-bind="$attrs">
        <div class="table-cell-container" :style="styles">
            <template v-if="'default' in $slots">
                <slot />
            </template>
            <template v-else>{{ normalizeValue }}</template>
        </div>
    </td>
</template>

<style lang="sass" scoped>
table
    tbody tr
        &:first-child th
            border-bottom: none
        td
            border-top: $table-border
            border-right: $table-border
            &:first-child
                border-left: none
            &:last-child
                border-right: none
            .table-cell-container
                width: 100%
                height: 100%
                padding: 15px 10px
                text-align: left
</style>
