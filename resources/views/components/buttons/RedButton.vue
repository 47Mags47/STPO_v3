<script>
import BaseButton from "./BaseButton.vue";

export default {
    props: {
        text: {
            type: String,
        },
    },
    components: {
        BaseButton,
    },
    slots: ["default"],
};
</script>

<template>
    <BaseButton color="red">
        <template v-if="$slots.default"><slot name="default" /></template>
        <template v-else>{{ text }}</template>
    </BaseButton>
</template>

<style lang="sass" scoped>
.button.red-button
    background: var(--danger-button-background-color)
    &:hover, &.active
        background: var(--danger-button-background-color-hover)
        box-shadow: var(--danger-button-shadow)
</style>
