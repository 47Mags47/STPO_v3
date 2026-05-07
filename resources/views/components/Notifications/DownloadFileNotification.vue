<script>
import RedButton from "../buttons/RedButton.vue";
import Ico from "../Ico.vue";
import BaseNotification from "./BaseNotification.vue";
import { router } from "@inertiajs/vue3";

export default {
    components: {
        BaseNotification,
        Ico,
        RedButton,
    },
    props: {
        link: {
            type: String,
        },
        fileName: {
            type: String,
        },
        text: {
            type: String,
        },
    },
    methods: {
        downoadClickButtonHandler(){
            router.get(this.link)
        }
    }
};
</script>

<template>
    <BaseNotification class="download-file-notification-container">
        <template #header> SYSTEM </template>

        <template #ico>
            <Ico type="faFile" />
        </template>

        <template #content>
            <div class="download-file-notification-content">
                <span class="message">Файл {{ fileName }} готов к загрузке.</span>
                <RedButton :onClick="downoadClickButtonHandler" >
                    <Ico type="faDownload" />
                </RedButton>
            </div>
        </template>
    </BaseNotification>
</template>

<style lang="sass" scoped>
.download-file-notification-container
    .download-file-notification-content
        display: flex
        justify-content: space-between
        .button
            width: 30px
            height: 30px
            padding: 5px
</style>
