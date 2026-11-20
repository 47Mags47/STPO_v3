<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        SingleSelectPopup:  defineAsyncComponent(()   => import('./types/SingleSelectPopup.vue')),
        MultiSelectPopup:   defineAsyncComponent(()   => import('./types/MultiSelectPopup.vue')),
    },

    props: {
        type: {
            type: String,
            default: 'single'
        }
    }

    // HACK перенести валидацию типов с ресурсов (form, table) сюда
}
</script>

<template>
    <SingleSelectPopup v-if="type === 'single'" v-bind="$attrs" />
    <MultiSelectPopup  v-if="type === 'multi'"  v-bind="$attrs" />
</template>
