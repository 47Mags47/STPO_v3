<script>
import MaskInput from './MaskInput.vue';

export default {
    components: {
        MaskInput
    },
    props: {
        hasDob: {
            type: Boolean,
            default: false
        },
        name: {
            type: String,
            default: 'phone'
        },
        value: {
            type: String,
            default: null
        },
        dobValue: {
            type: String,
            default: null
        }
    }
}
</script>

<template>
    <div class="phone-input-container">
        <MaskInput
            type="tel"
            mask="+7 (###) ### ##-##"
            placeholder="+7 (999) 999 99-99"
            :name
            :value
            v-bind="$attrs"
        />
        <MaskInput
            v-if="hasDob"
            type="number"
            max="999999"
            mask="######"
            placeholder="0000"
            :name="`${name}_dob`"
            :value="dobValue"
            v-bind="$attrs"
        />
    </div>
</template>

<style lang="sass" scoped>
.phone-input-container
    display: flex
    gap: 15px
    :deep(input[name="phone_dob"])
        width: 9ch
</style>
