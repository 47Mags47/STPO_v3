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
            type: [String, Object],
            default: null,
        },

        onInput:{
            type: Function,
            default: () => {}
        },
        onChange:{
            type: Function,
            default: () => {}
        },
    },

    data(){
        return {
            phoneLocalValue: this.hasDob ? this.value?.phone : this.value,
            dobLocalValue: this.hasDob ? (this.value?.dob ?? null): null,
        }
    },

    methods: {
        onInputPhoneHandler(e, value){
            this.phoneLocalValue = value

            this.onInput(e, this.hasDob
                ? {
                    phone: this.phoneLocalValue,
                    dob: this.dobLocalValue
                }
                : value
            )
        },
        onInputDobHandler(e, value){
            this.dobLocalValue = value

            this.onInput(e, {
                phone: this.phoneLocalValue,
                dob: this.dobLocalValue
            })
        },

        onChangePhoneHandler(e, value){
            this.phoneLocalValue = value

            this.onChange(e, this.hasDob
                ? {
                    phone: this.phoneLocalValue,
                    dob: this.dobLocalValue
                }
                : value
            )
        },
        onChangeDobHandler(e, value){
            this.dobLocalValue = value

            this.onChange(e, {
                phone: this.phoneLocalValue,
                dob: this.dobLocalValue
            })
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
            :value="hasDob ? (value?.phone ?? null) : value"
            :onInput="onInputPhoneHandler"
            :onChange="onChangePhoneHandler"
            v-bind="$attrs"
        />
        <MaskInput
            v-if="hasDob"
            type="number"
            max="999999"
            mask="######"
            placeholder="0000"
            :name="`${name}_dob`"
            :value="value !== null ? value.dob: null"
            :onInput="onInputDobHandler"
            :onChange="onChangeDobHandler"
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
