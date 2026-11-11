<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        Message: defineAsyncComponent(() => import('./types/Message.vue')),
        File: defineAsyncComponent(() => import('./types/File.vue')),
        Info: defineAsyncComponent(() => import('./types/Info.vue')),
        Alert: defineAsyncComponent(() => import('./types/Alert.vue')),
    },

    props: {
        type: {
            type: Object
        },
    }
}
</script>

<template>
    <Message v-if="type.code === 'message'" :type v-bind="$attrs" />
    <File    v-if="type.code === 'file'"    :type v-bind="$attrs" />
    <Info    v-if="type.code === 'info'"    :type v-bind="$attrs" />
    <Alert   v-if="type.code === 'alert'"   :type v-bind="$attrs" />
</template>
