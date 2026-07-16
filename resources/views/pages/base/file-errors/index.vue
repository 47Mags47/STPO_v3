<script>
import { ResourceTable } from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceTable,
    },

    computed: {
        errors: () => usePage().props.errors,
    },
};
</script>

<template>
    <ResourceTable
        caption="Ошибки файла"
        :data="errors.data"
        :meta="errors.meta"
        :collumns="[
            {
                title: 'Описание',
                dataIndex: 'error',
            },
        ]"
    />
</template>
