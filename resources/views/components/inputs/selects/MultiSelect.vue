<script>
import Checkbox from '../Checkbox.vue';
import BaseSelect from './BaseSelect.vue';

export default {
    components: {
        BaseSelect,
        Checkbox,
    },

    data() {
        return {
            isOpen: false,
            localValue: this.value,
            localOptions: this.options,
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
            default: 'id'
        },
        placeholder: {
            type: String,
            default: 'Выбрано:'
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {}
        },

        // OTHER
        options: {
            type: Array,
            default: () => [{}],

            validator(options) {
                return options.every(option => typeof(option) === 'object')
            }
        },
    },

    methods: {
        openList() {
            this.isOpen = true;
        },
        closeList() {
            this.isOpen = false;
        },
        inputClickHandler() {
            this.isOpen = !this.isOpen;

            if (this.isOpen)
                this.openList()
        },
        optionClickHandler(option) {
            if (this.localValue.includes(option))
                this.localValue = this.localValue.filter(item => item !== option);
            else
                this.localValue.push(option);
        },
        searchInputHandler(e) {
            this.localOptions = this.options.filter(option => this.getOptionLabel(option)?.toLowerCase().includes(e.target.value.toLowerCase()));
        },

        // MATH
        isOptionSelected(option) {
            return this.localValue.includes(Object.get(option, this.valueKey))
        },
        isKeyHover(activeElementIndex, index) {
            return activeElementIndex === index
        },
        getOptionLabel(option) {
            if (option === null)
                return null

            return Object.get(option, this.labelKey)
        },
        getOptionValue(option) {
            if (option === null)
                return null

            return Object.get(option, this.valueKey)
        },
    },

    watch: {
        value(val) {
            this.localValue = val
        },
        options(options) {
            this.localOptions = structuredClone(options)
        }
    },

    computed: {
        placeholderValue() {
            return `
                ${this.placeholder}
                ${this.localValue.length}
            `
        }
    }
}
</script>

<template>
    <BaseSelect
        :is-open
        :placeholder="placeholderValue"
        :options="localOptions"
        :on-close="closeList"
        :on-input-click="inputClickHandler"
        :on-option-click="optionClickHandler"
        :on-search-input="searchInputHandler"
    >
        <template #dropdown="{ onKey, activeElementIndex }">
            <label
                v-for="(option, index) in localOptions"
                :key="index"
                class="select-list-option"
                :class="{
                    'selected': isOptionSelected(option),
                    'key-hover':  isKeyHover(activeElementIndex, index)
                }"
            >
                <Checkbox
                    :value="localValue.includes(Object.get(option, valueKey))"
                    :name="`${name}[${Object.get(option, valueKey)}]`"
                    :on-change="(event, value) => onChange(event, option)"
                    @click="optionClickHandler(Object.get(option, this.valueKey))"
                    @keydown="onKey"
                />
                <span> {{ option.label }} </span>
            </label>
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
