<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        Message: defineAsyncComponent(() => import('./types/Message.vue'))
    },

    props: {
        type: {
            type: Object
        },
    }
}
</script>

<template>
    <Message v-if="type.code === 'message'" v-bind="$attrs" />
</template>
