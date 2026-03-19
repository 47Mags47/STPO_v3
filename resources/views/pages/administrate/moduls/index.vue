<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable, List } from "@components";

export default {
    components: {
        ResourceTable,
        List,
    },
    computed: {
        moduls: () => usePage().props.moduls,
    },
};
</script>

<template>
    <ResourceTable
        caption="Модули"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="moduls.data"
        :meta="divisions.meta"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
            {
                title: 'Наименование роута',
                dataIndex: 'route_name',
            },
            {
                title: 'Группа',
                dataIndex: 'group.name',
            },
            {
                title: 'Создатель',
                dataIndex: 'creator_id',
            },
        ]"
    />
</template>
