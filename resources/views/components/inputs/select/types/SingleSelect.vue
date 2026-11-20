<script>
import BaseSelect from "../BaseSelect.vue";
import Input from '../../input/Input.vue';

export default {
    components: {
        BaseSelect,
        Input,
    },

    props: {
        // INPUT
        name: {
            type: String,
            default: "",
        },
        value: {
            type: Number,
            default: null,
        },
        labelKey: {
            type: String,
            default: "name",
        },
        valueKey: {
            type: String,
            default: "id",
        },

        // HANDLERS
        onChange: {
            type: Function,
            default: () => {},
        },
    },

    data() {
        return {
            isOpen: false,
            localValue: null,
        };
    },

    methods: {
        optionClickHandler(optionValue) {
            this.localValue = optionValue
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
};
</script>

<template>
    <BaseSelect
        type="single"
        :value="localValue"
        :label-key
        :value-key
        :on-option-click="optionClickHandler"
    >
        <template #option="{ option, selected, onKey, onOptionClick }">
            <Input type="radio"
                :value="localValue"
                :checked="selected"
                :name="`${name}[]`"
                :on-change="(event) => onChange(event, option)"
                @click="onOptionClick"
                @keydown="onKey"
            />
            <span>{{ Object.get(option, labelKey) }}</span>
        </template>
    </BaseSelect>
</template>

<style lang="sass" scoped>
</style>
