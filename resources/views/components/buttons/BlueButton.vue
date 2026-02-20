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
    slots: ["default"],
    components: {
        BaseButton,
    },
};
</script>

<template>
    <BaseButton color="blue" @click="onClick">
        <template v-if="$slots.default"><slot name="default" /></template>
        <template v-else>{{ text }}</template>
    </BaseButton>
</template>

<style lang="sass" scoped>
.blue-button
    background: $blue-button-background
    &:hover
        background: $blue-button-backgroun-hover
        box-shadow: $blue-button-shadow
</style>
