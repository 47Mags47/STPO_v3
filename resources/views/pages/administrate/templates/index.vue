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
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
            {
                title: 'Вид',
                dataIndex: 'style.name',
            },
            {
                title: 'Тип',
                dataIndex: 'type.name',
            },
            {
                title: 'Разбивать',
                dataIndex: 'chunk',
            },
        ]"
    />
</template>
