<script>
import { defineAsyncComponent } from 'vue';

export default {
    inheritAttrs: false,
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
    <SingleSelect v-if="type === 'singleSelect'" v-bind="$attrs" />
    <MultiSelect  v-if="type === 'multiSelect'"  v-bind="$attrs" />
    <MonthSelect  v-if="type === 'monthSelect'"  v-bind="$attrs" />
    <YearSelect   v-if="type === 'yearSelect'"   v-bind="$attrs" />
</template>
