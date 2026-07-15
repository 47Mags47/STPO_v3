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
        file: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            isDelete: false,
        }
    },
    methods: {
        downoadClickButtonHandler() {
            window.open(route('files.download', { file: this.file.file_id }))
        }
    }
};
</script>

<template>
    <BaseNotification type="download-file-notification" ico="file">
        <template v-slot:actions>
            <RedButton :onClick="downoadClickButtonHandler">
                <Ico type="download" />
            </RedButton>
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
