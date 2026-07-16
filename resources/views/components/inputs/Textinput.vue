<script>
export default {
    props: {
        id: {
            type: String,
            default: (props) => props.name,
        },
        name: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: null,
        },
        required: {
            type: Boolean,
            default: false,
        },
        value: {
            type: String,
            default: '',
        },
        autocomplete: {
            type: String,
            default: 'on',
        },

        hidden: {
            type: Boolean,
            default: false,
        },

        resize: {
            type: String,
            default: 'none',
        },

        onInput: {
            type: Function,
            default: () => { },
        },
        onChange: {
            type: Function,
            default: () => { },
        }
    },

    methods: {
        inputHandler(e) {
            this.onInput(e);
        },
        changeHandler(e) {
            this.onChange(e);
        },
    },
}
</script>

<template>
    <textarea
        v-show="!hidden"
        :class="{ 'text-input': true }"
        :id
        :name
        :placeholder
        :required
        :autocomplete
        :value="value"
        :style="{ 'resize': resize }"
        @input="inputHandler"
        @change="changeHandler"
    />
</template>

<style lang="sass" scoped>
.text-input
    @include input()

    height: calc( 7.7rem + 10px )
</style>
