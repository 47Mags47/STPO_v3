<script>
import { router } from "@inertiajs/vue3";

import Ico from "../../Ico.vue";
import BlueButton from "../../buttons/BlueButton.vue"
import BaseNotification from "./../BaseNotification.vue"

export default {
    components: {
        BaseNotification,
        Ico,
        BlueButton
    },
    props: {
        message: {
            type: String,
            default: null
        },
        closeFunction: {
            type: Function,
            default: () => ({})
        }
    },

    methods: {
        goToMessageClickHandler() {
            router.get(this.context.target_url)
            this.closeFunction()
        }
    }
};
</script>

<template>
    <BaseNotification>
        <template #content>
            <p class="message-text">{{ message }}</p>
        </template>
    </BaseNotification>
</template>

<style lang="sass" scoped>
.notification-container
    .message-text
        overflow-wrap: break-word
</style>
