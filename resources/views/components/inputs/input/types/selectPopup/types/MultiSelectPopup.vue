<script>
import BaseSelectPopup from '../BaseSelectPopup.vue';

export default {
    components: {
        BaseSelectPopup,
    },

    props: {
        // INPUT
        labelKey: {
            type: String,
            default: 'name'
        },
        valueKey: {
            type: String,
            default: 'id'
        },
        value: {
            type: Array,
            default: []
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
    },

    data() {
        return {
            localValue: null,
        }
    },

    methods: {
        changeOptionHandler(e, option) {
            const value = Object.get(option, this.valueKey)

            if (this.localValue.includes(value))
                this.localValue = this.localValue.filter(optionValue => optionValue !== value)
            else
                this.localValue.push(value)

            this.onChange(e, option)
        },
    },

    watch: {
        value: {
            handler(val) {
                this.localValue = [...val]
            },
            immediate: true,
            deep: true
        }
    },

    computed: {
        placeholderValue() {
            return `${this.placeholder} ${this.localValue.length}`
        }
    }
}
</script>

<template>
    <BaseSelectPopup
        :value="localValue"
        :placeholder="placeholderValue"
        :on-change="changeOptionHandler"
    />
</template>

<style lang="sass" scoped>
</style>
