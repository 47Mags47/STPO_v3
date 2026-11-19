<script>
export default {
    props: {
        id: {
            type: [String, null],
            default: (props) => props.name,
        },
        type: {
            type: [String, null],
            default: 'text',
        },
        name: {
            type: [String, null],
        },
        placeholder: {
            type: [String, null],
            default: null,
        },
        required: {
            type: Boolean,
            default: false,
        },
        value: {
            type: [String, Boolean, Number],
            default: '',
        },
        checked: {
            type: Boolean,
            default: false
        },
        autocomplete: {
            type: Boolean,
            default: false,
        },
        form: {
            type: String,
            default: null
        },

        hidden: {
            type: Boolean,
            default: false,
        },
        readonly: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },

        onInput: {
            type: Function,
            default: () => {},
        },
        onClick: {
            type: Function,
            default: () => {},
        },
        onChange: {
            type: Function,
            default: () => {},
        }
    },

    methods: {
        inputHandler(e) {
            this.onInput(e, e.target.value);
        },
        changeHandler(e){
            this.onChange(e, e.target.value);
        },

        clickHandler(e){
            this.onClick(e);
        },

        getInputElement(){
            return this.$refs.input
        }
    },
};
</script>

<template>
    <input
        ref="input"
        :class="{ 'base-input': true, 'hidden': hidden, 'readonly': readonly, 'disabled': disabled }"
        :type
        :id
        :name
        :placeholder
        :required
        :autocomplete
        :value
        :readonly
        :disabled
        :form
        :checked
        @input="inputHandler"
        @click="clickHandler"
        @change="changeHandler"
    />
</template>

<style lang="sass" scoped>
.base-input
    @include input()

    &.hidden
        display: none

    &.readonly
        color: #aaa

    &.disabled
        color: #aaa
        border: 1px solid #aaa
        cursor: not-allowed
</style>
