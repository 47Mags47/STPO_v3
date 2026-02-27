<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        modulGroups: () => usePage().props.modulGroups,
    },
    setup() {
        const columns = [
            {
                title: "Код",
                dataIndex: "code",
            },
            {
                title: "Наименование",
                dataIndex: "name",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        header="Группы модулей"
        :columns
        :data="modulGroups"
        :hasDelete="true"
        :hasEdit="true"
        :hasPaginate="true"
    />
</template>
