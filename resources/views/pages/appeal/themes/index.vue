<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        themes: () => usePage().props.themes,
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

        :data="themes.data"
        :meta="themes.meta"
        :columns="[
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
