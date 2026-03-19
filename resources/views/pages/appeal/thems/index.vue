<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        thems: () => usePage().props.thems,
    },
    setup() {
        const columns = [
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
            {
                title: 'Группа',
                dataIndex: 'group.name',
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        caption="Темы обращений"

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
                title: 'Группа',
                dataIndex: 'group.name',
            },
        ]"
    />
</template>
