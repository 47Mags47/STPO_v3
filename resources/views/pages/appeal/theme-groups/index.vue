<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        theme_groups: () => usePage().props.theme_groups,
    },
};
</script>

<template>
    <ResourceTable
        caption="Группы тем обращений"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="theme_groups.data"
        :meta="theme_groups.meta"
        :columns="[
            {
                title: 'Код',
                dataIndex: 'code',
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
