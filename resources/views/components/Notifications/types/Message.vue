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
        context: {
            type: Object,
            default: () => ({})
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
    <BaseNotification type="message" ico="message">
        <template #content>
            <p class="message-text">{{ message }}</p>
        </template>
        <template #action>
            <BlueButton v-if="context.target_url" class="go-to-message" @click="goToMessageClickHandler">
                Перейти в чат
                <Ico type="arrow-right" />
            </BlueButton>
        </template>
    </BaseNotification>
</template>

<style lang="sass" scoped>
.notification-container
    .message-text
        overflow-wrap: break-word

    .go-to-message
        .ico-container
            width: 20px
            height: 20px
</style>
