<script>
import BaseButton from "./BaseButton.vue";

export default {
    props: {
        text: {
            type: String,
        },
    },
    slots: ["default"],
    components: {
        BaseButton,
    },
};
</script>

<template>
    <BaseButton color="blue">
        <template v-if="$slots.default"><slot name="default" /></template>
        <template v-else>{{ text }}</template>
    </BaseButton>
</template>

<style lang="sass" scoped>
.button.blue-button
    background: var(--button-background-color)
    &:hover, &.active
        background: var(--button-background-color-hover)
        box-shadow: var(--button-shadow)
</style>
