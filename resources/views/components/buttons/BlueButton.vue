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
    background: $blue-button-background
    &:hover, &.active
        background: $blue-button-backgroun-hover
        box-shadow: $blue-button-shadow
</style>
