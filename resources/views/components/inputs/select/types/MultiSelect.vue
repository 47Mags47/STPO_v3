<script>
import Checkbox from '../../Checkbox.vue';
import BaseSelect from '../BaseSelect.vue';

export default {
    components: {
        BaseSelect,
        Checkbox,
    },

    data() {
        return {
            localValue: []
        }
    },

    props: {
        // INPUT
        name: {
            type: String,
            default: ''
        },
        value: {
            type: Array,
            default: () => ([])
        },
        labelKey: {
            type: String,
            default: 'name'
        },
        valueKey: {
            type: String,
            default: "id",
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {}
        },
    },

    methods: {
        optionClickHandler(optionValue) {
            if (this.localValue.includes(optionValue))
                this.localValue = this.localValue.filter(item => item !== optionValue);
            else
                this.localValue.push(optionValue);
        },
    },

    watch: {
        value: {
            handler(val) {
                this.localValue = val
            },
            immediate: true
        },
    },
}
</script>

<template>
    <BaseSelect
        type="multi"
        :value="localValue"
        :label-key
        :value-key
        :on-option-click="optionClickHandler"
    >
        <template #option="{ option, selected, onKey, onOptionClick }">
            <Checkbox
                :value="Object.get(option, valueKey)"
                :checked="selected"
                :name="`${name}[]`"
                :on-change="(event, value) => onChange(event, option)"
                @click="onOptionClick"
                @keydown="onKey"
            />
            <span> {{ Object.get(option, labelKey) }} </span>
        </template>
    </BaseSelect>
</template>

<style lang="sass" scoped>
.select-list-option
    padding: 5px 0
    padding-left: 7px

    display: flex
    gap: 7px

    cursor: pointer

    &.selected
        background-color: var(--option-background-selected)
    &:hover, &.key-hover
        background-color: var(--option-background-hover)
</style>
