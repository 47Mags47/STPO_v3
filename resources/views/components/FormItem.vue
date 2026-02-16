<script>
export default {
    props: {
        label: {
            type: String,
            default: ''
        },
        for: {
            type: String,
            default: ''
        }
    },
    slots: [
        'default'
    ]
}
</script>

<template>
    <div class="form-item-container">
        <label :for>{{ label }}</label>
        <slot name="default" />
    </div>
</template>

<style lang="sass" scoped>
.form-item-container
    display: flex
    gap: 3px
    flex-direction: column
    :deep()
        label
            padding-left: 7px
            color: #333
            font-weight: 600
</style>
