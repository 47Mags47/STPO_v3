<script>

</script>

<template>
    <div class="size-full flex flex-col overflow-hidden">
        <main id="messagesContainer"
        class="chat-content-wrapper size-full min-h-0">
            <slot name="content" />
        </main>

        <footer class="chat-footer">
            <slot name="footer" />
        </footer>
    </div>
</template>

<style lang="sass" scoped>
.chat-content-wrapper
    background: var(--background-color)

.chat-footer
    background: var(--chat-footer-background-color)
</style>
