<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        them_groups: () => usePage().props.them_groups,
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
        header="Группы тем обращений"
        :columns
        :data="them_groups"
        :hasDelete="true"
        :hasEdit="true"
        :hasPaginate="true"
    />
</template>
