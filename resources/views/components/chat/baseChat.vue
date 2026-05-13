<script>

</script>

<template>
    <div class="size-full flex flex-col drop-shadow-lg">
        <header class="h-[64px] bg-(--meny-background) w-full flex items-center gap-3 px-4! py-2!">
            <slot name="header"/>
        </header>

        <main id="messagesContainer" class="grow w-full flex bg-white flex-col p-4! custom-scrollbar">
            <slot name="content" />
        </main>

        <footer class="min-h-[124px] bg-white shadow-[0_-4px_10px_rgba(0,0,0,0.08)] w-full flex flex-col justify-center px-10! py-10!">
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
