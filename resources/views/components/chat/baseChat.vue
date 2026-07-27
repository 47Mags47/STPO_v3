<script>

</script>

<template>
    <div class="size-full flex flex-col overflow-hidden">
        <main id="messagesContainer"
        class="size-full bg-white min-h-0">
            <slot name="content" />
        </main>

        <footer>
            <slot name="footer" />
        </footer>
    </div>
</template>

<style lang="sass" scoped>
</style>
