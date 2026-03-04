<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        id: {
            type: String,
        },
        value: {
            type: [String, Number, Boolean],
            default: null,
        },
        label: {
            type: String,
        },
        placeholder: {
            type: String,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        readonly: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<template>
    <textarea
        :id="id ?? name"
        :name
        :value
        :placeholder="placeholder ?? name"
        :disabled
        :readonly
    >
            {{ value }}
        </textarea
    >
</template>

<style lang="sass" scoped>

textarea
    height: $textarea-height
    padding: $input-padding
    font-size: $input-font-size
    border-radius: $input-border-radius
    border: $input-border

    resize: none
</style>
