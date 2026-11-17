<script>
import RadioButton from "../../RadioButton.vue";
import BaseSelect from "../BaseSelect.vue";

export default {
    components: {
        BaseSelect,
        RadioButton,
    },

    data() {
        return {
            isOpen: false,
            localValue: this.value,
        };
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

    methods: {
        optionClickHandler(optionValue) {
            this.localValue = optionValue
        },
    },

    watch: {
        value(val) {
            this.localValue = val;
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
            <RadioButton
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
