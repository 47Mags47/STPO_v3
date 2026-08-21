<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },

    computed: {
        templates: () => usePage().props.templates,
    },
};
</script>

<template>
    <ResourceTable
        caption="Шаблоны"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="templates.data"
        :meta="templates.meta"
        :collumns="[
            {
                title: 'Writer',
                dataIndex: 'writer',
                width: '250px'
            },
            {
                title: 'Описание',
                dataIndex: 'description',
            },
            {
                title: 'Файл шаблона',
                dataIndex: 'file.name',
            },
        ]"
    />
</template>
