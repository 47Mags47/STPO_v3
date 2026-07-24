<script>
import Ico from "../Ico.vue";
import BaseNotification from "./BaseNotification.vue"
import BlueButton from "../buttons/BlueButton.vue"
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        BaseNotification,
        Ico,
        BlueButton
    },
    props: {
        appealId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            isDelete: false,
        }
    },

    methods: {
        goToNewMessage() {
            router.get(route('appeal.messages.index', { appeal: this.appealId }))
        }
    }
};
</script>

<template>
    <BaseNotification type="new-message-notification" ico="message" >
         <template v-slot:actions>
            <BlueButton :onClick="goToNewMessage">
                <Ico type="reply" />
            </BlueButton>
         </template>
    </BaseNotification>
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
