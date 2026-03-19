<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        modulGroups: () => usePage().props.modulGroups,
    },
};
</script>

<template>
    <ResourceTable
        caption="Группы модулей"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="modulGroups.data"
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
