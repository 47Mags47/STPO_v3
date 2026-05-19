<script>

</script>

<template>
    <div class="size-full flex flex-col drop-shadow-lg overflow-hidden">
        <header v-if="$slots.header"
        class="h-[40px] bg-(--meny-background) w-full flex items-center gap-3 px-4! py-2! shrink-0">
            <slot name="header"/>
        </header>

        <main id="messagesContainer"
        class=" w-full flex bg-white flex-col-reverse px-4! pb-4! custom-scrollbar min-h-0 h-full">
            <slot name="content" />
        </main>

        <footer
        class="relative h-[76px] w-full bg-white shadow-[0_-4px_10px_rgba(0,0,0,0.08)] flex gap-3 justify-center px-4! py-4!">
            <slot name="footer" />
        </footer>
    </div>
</template>

<style lang="sass" scoped>
.custom-scrollbar
    scrollbar-gutter: stable
    overflow-y: auto

    &::-webkit-scrollbar
        height: 100%
        width: 5px

    // Трек (дорожка)
    &::-webkit-scrollbar-track
        background: #3d9bd16c
        border-radius: 10px

    // Ползунок
    &::-webkit-scrollbar-thumb
        background: #6cbbe9
        border-radius: 10px
        transition: background 0.2s ease
        cursor: pointer

        &:hover
            background: #80d0ff
</style>
