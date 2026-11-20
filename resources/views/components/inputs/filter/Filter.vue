<script>
import { defineAsyncComponent } from 'vue';

export default {
    components: {
        CheckboxFilter:            defineAsyncComponent(() => import('./types/CheckboxFilter.vue')),
        MultiSelectFilter:         defineAsyncComponent(() => import('./types/MultiSelectFilter.vue')),
        MultiSelectPopupFilter:    defineAsyncComponent(() => import('./types/MultiSelectPopupFilter.vue')),
        DateFilter:                defineAsyncComponent(() => import('./types/DateFilter.vue')),
    },

    props: {
        type: {
            type: String,
            default: 'multiSelect'
        }
    }

    // HACK перенести валидацию типов с ресурсов (form, table) сюда
}
</script>

<template>
    <CheckboxFilter           v-if="type === 'checkbox'"           v-bind="$attrs" />
    <SingleSelectFilter       v-if="type === 'singleSelect'"       v-bind="$attrs" />
    <MultiSelectFilter        v-if="type === 'multiSelect'"        v-bind="$attrs" />
    <MultiSelectPopupFilter   v-if="type === 'multiSelectPopup'"   v-bind="$attrs" />
    <DateFilter               v-if="type === 'date'"               v-bind="$attrs" />
</template>
