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
    width: 100%
    height: 100%
</style>
