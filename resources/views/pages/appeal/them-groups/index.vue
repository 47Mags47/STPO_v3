<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        them_groups: () => usePage().props.them_groups,
    },
};
</script>

<template>
    <ResourceTable
        caption="Группы тем обращений"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="them_groups.data"
        :meta="divisions.meta"
        :collumns="[
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
