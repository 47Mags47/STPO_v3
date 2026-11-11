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
        goToFileClickHandler() {
            router.get(route('files.download', { 'file': this.context.file_id}))
            this.closeFunction()
        }
    }
};
</script>

<template>
    <BaseNotification>
        <template #content>
            <p class="message-text">
                Файл "{{ context.file_name }}" готов к загрузке
            </p>
        </template>
        <template #action>
            <BlueButton v-if="context.file_id" class="go-to-file" @click="goToFileClickHandler">
                Загрузить файл
                <Ico type="download" />
            </BlueButton>
        </template>
    </BaseNotification>
</template>

<style lang="sass" scoped>
.notification-container
    .message-text
        overflow-wrap: break-word

    .go-to-file
        .ico-container
            width: 20px
            height: 20px
</style>
