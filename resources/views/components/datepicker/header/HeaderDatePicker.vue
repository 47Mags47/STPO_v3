<script>
import DaysOfWeek from './DaysOfWeek.vue';
import HeaderMenu from './HeaderMenu.vue';

export default {
    components: {
        DaysOfWeek,
        HeaderMenu,
    }
}

</script>


<template>
    <header class="flex flex-col justify-around rounded-t-lg
    bg-gradient-to-b from-[var(--meny-background)] to-cyan-100">
        <HeaderMenu class=""
        @month-left="$emit('monthLeft')"
        @month-right="$emit('monthRight')"/>
        <DaysOfWeek class=""/>
    </header>
</template>

<style lang="scss" scoped>

</style>
