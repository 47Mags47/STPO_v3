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
            required: true,
        },
        placeholder: {
            type: [String, null],
            default: null,
        },
        required: {
            type: Boolean,
            default: false,
        },
        value:{
            type: [String, Boolean, Number],
            default: '',
        },

        onInput:{
            type: Function,
            default: () => { }
        }
    },

    methods:{
        inputHandler(e){
            this.onInput(e)
        }
    },
}
</script>

<template>
    <input
        class="base-input"
        :type
        :id
        :name
        :placeholder
        :required
        :value
        @input="inputHandler"
    >
</template>

<style lang="sass" scoped>
.base-input
    width: 100%
    height: $input-height

    padding: $input-padding

    border: $input-border
    border-radius: $input-border-radius

    font-size: $input-font-size
    color: #333

    transition: .3s
</style>
