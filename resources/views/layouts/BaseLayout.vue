<script>
export default {
    props: ["name"],
};
</script>

<template>
    <div :class="['layout', name]">
        <slot />
    </div>
</template>

<style lang="sass" scoped>
.layout
    color: var(--text-color)
    width: 100%
    height: 100%
</style>
