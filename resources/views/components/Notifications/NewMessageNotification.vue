<script>
import Ico from "../Ico.vue";
import BaseNotification from "./BaseNotification.vue"

export default {
    components: {
        BaseNotification,
        Ico,
    },
    props: {
    },
    data() {
        return {
            isDelete: false,
        }
    },
};
</script>

<template>
    <BaseNotification type="new-message-notification" ico="message" />
</template>

<style lang="sass" scoped>
.download-file-notification
    .notification-content
        display: flex
        justify-content: space-between
        .button
            width: 30px
            height: 30px
            padding: 5px
</style>
