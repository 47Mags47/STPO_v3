<script>

</script>

<template>
    <div class="size-full flex flex-col drop-shadow-lg overflow-hidden">
        <header v-if="$slots.header"
        class="h-[40px] bg-white drop-shadow-md w-full flex items-center gap-5 px-4! py-2! shrink-0">
            <slot name="header"/>
        </header>

        <main id="messagesContainer"
        class="size-full bg-white min-h-0">
            <slot name="content" />
        </main>

        <footer
        class="relative h-[76px] w-full bg-white shadow-[0_-4px_10px_rgba(0,0,0,0.08)] flex gap-3 justify-center px-4! py-4!">
            <slot name="footer" />
        </footer>
    </div>
</template>

<style lang="sass" scoped>
</style>
