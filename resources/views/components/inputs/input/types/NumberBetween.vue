<script>
import NumberInput from '../NumberInput.vue';

export default {
    components: {
        NumberInput
    },

    props: {
        // INPUT
        name: {
            type: String,
            required: true,
        },
        value: {
            type: Object,
            default: {
                from: null,
                to: null
            }
        },
        placeholder: {
            type: Object,
            default: {
                from: 'От',
                to:   'До'
            },
        },

        // HANDLERS
        onChangeFrom: {
            type: Function,
            default: () => {}
        },
        onChangeTo: {
            type: Function,
            default: () => {}
        }
    }
}
</script>

<template>
    <div class="number-between-wrapper">
        <NumberInput
        :name="`${name}[from]`"
        :value="value.from"
        :on-change="onChangeFrom"
        :placeholder="placeholder.from"/>

        <span>—</span>

        <NumberInput
        :name="`${name}[to]`"
        :value="value.to"
        :on-change="onChangeTo"
        :placeholder="placeholder.to"/>
    </div>
</template>

<style scoped lang="sass">
.number-between-wrapper
    width: 100%
    height: 100%
    display: flex
    align-items: center
    gap: 4px

    input
        width: 64px
        padding: 4px 10px
        border: var(--border)
        border-radius: 8px
        font-size: 14px
        line-height: 1.4
</style>
