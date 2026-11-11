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
    <BaseNotification ico="message">
        <template #content>
            <div class="message-container">
                <span>{{ message }}</span>
            </div>
            <div v-if="context.target_url" class="action-container">
                <BlueButton :onClick="goToMessageClickHandler">
                    <Ico type="corner-up-right" />
                </BlueButton>
            </div>
        </template>
    </BaseNotification>
</template>

<style lang="sass" scoped>
.notification-content
    display: flex
    flex-direction: column
    .message-container
        word-wrap: break-word
    .action-container
        width: 100%
        height: 30px

        display: flex
        justify-content: end
</style>
