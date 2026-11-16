<script>
import RadioButton from '../RadioButton.vue';
import BaseSelect from './BaseSelect.vue';

export default {
    components: {
        BaseSelect,
        RadioButton,
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
        // HANDLERS
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
            this.localValue = [option]
        },
        searchInputHandler(e) {
            this.localOptions = this.options.filter(option => this.getOptionLabel(option)?.toLowerCase().includes(e.target.value.toLowerCase()));
        },

        // MATH
        isOptionSelected(option) {
            return this.localValue[0] === Object.get(option, this.valueKey)
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
                ${this.localOptions.find(option => this.getOptionValue(option) === this.localValue[0])?.[this.labelKey] ?? ''}
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
                <RadioButton
                    :value="localValue[0]"
                    :checked="localValue[0] === Object.get(option, valueKey)"
                    :name="`${name}[]`"
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
