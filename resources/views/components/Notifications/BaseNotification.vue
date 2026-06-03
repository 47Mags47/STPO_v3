<script>
export default {
    slots: ["header", "ico", "content"],
};
</script>

<template>
    <div class="notification-container">
        <div class="notification-header">
            <slot name="header" />
        </div>

        <div class="notification-content-line">
            <div class="notification-content">
                <slot name="content" />
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
.notification-container
    position: relative
    padding: 4px 6px
    .notification-header
        display: flex
        align-items: center
        font-weight: bold
        gap: 5px
        :deep()
            .ico-container
                width: 16px
                height: 16px
                // padding: 5px
    .notification-content-line
        .notification-content
            padding: 10px 0 5px 0
</style>
