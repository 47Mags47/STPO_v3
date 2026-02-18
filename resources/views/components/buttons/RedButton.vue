<script>
import BaseButton from "./BaseButton.vue";

export default {
    props: {
        text: {
            type: String,
        },
        onClick: {
            type: Function,
        },
    },
    components: {
        BaseButton,
    },
    slots: ["default"],
};
</script>

<template>
    <BaseButton color="red" @click="onClick">
        <template v-if="$slots.default"><slot name="default" /></template>
        <template v-else>{{ text }}</template>
    </BaseButton>
</template>

<style lang="sass" scoped>
.red-button
    background: $red-button-background
    &:hover
        background: $red-button-backgroun-hover
        box-shadow: $red-button-shadow
</style>
