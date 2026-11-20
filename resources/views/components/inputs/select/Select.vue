<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        MultiSelect: defineAsyncComponent(()    => import('./types/MultiSelect.vue')),
        SingleSelect: defineAsyncComponent(()   => import('./types/SingleSelect.vue')),
        MonthSelect: defineAsyncComponent(()    => import('./types/MonthSelect.vue')),
        YearSelect: defineAsyncComponent(()     => import('./types/YearSelect.vue'))
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
    <SingleSelect v-if="type === 'single'" v-bind="$attrs" />
    <MultiSelect  v-if="type === 'multi'"  v-bind="$attrs" />
    <MonthSelect  v-if="type === 'month'"  v-bind="$attrs" />
    <YearSelect   v-if="type === 'year'"   v-bind="$attrs" />
</template>
