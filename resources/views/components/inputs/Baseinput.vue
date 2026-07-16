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
        autocomplete: {
            type: Boolean,
            default: false,
        },

        hidden: {
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
            this.onInput(e);
        },
        clickHandler(e){
            this.onClick(e);
        },
        changeHandler(e){
            this.onChange(e);
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
        :class="{ 'base-input': true, 'hidden': hidden }"
        :type
        :id
        :name
        :placeholder
        :required
        :autocomplete
        :value
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
</style>
