<script>
export default {
    slots: ["header", "ico", "content"],
};
</script>

<template>
    <div class="notification-container">
        <div class="notification-header">
            <slot name="ico" />
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
    .notification-header
        display: flex
        align-items: center
        font-weight: bold
        :deep()
            .ico-container
                width: 25px
                height: 25px
                padding: 5px
    .notification-content-line
        .notification-content
            padding: 5px 10px
</style>
