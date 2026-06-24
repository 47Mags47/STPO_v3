<script>
import Ico from "../Ico.vue";
import BaseNotification from "./BaseNotification.vue";

export default {
    components: {
        BaseNotification,
        Ico,
    },
    props: {
        auhtor: {
            type: String,
        },
        text: {
            type: String,
        },
    },
};
</script>

<template>
    <BaseNotification>
        <template #header>
            {{ auhtor }}
        </template>

        <template #ico>
            <Ico type="comment" />
        </template>

        <template #content>
            {{ text }}
        </template>
    </BaseNotification>
</template>
