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
            type: Number,
            default: null
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
            localLabel: '',
        }
    },

    methods: {
        changeOptionHandler(e, option) {
            this.localValue = Object.get(option, this.valueKey)
            this.localLabel = Object.get(option, this.labelKey)

            this.onChange(e, option)
        },
    },

    watch: {
        value: {
            handler(val) {
                if (!val)
                    return

                this.localValue = Object.get(val, this.valueKey)
                this.localLabel = Object.get(val, this.labelKey) ?? ''

                console.log( Object.get(val, this.labelKey))
            },
            immediate: true,
            deep: true,
        }
    },

    computed: {
        placeholderValue() {
            return `${this.placeholder} ${this.localLabel}`
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
