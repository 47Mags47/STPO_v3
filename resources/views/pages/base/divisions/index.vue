<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        divisions: () => usePage().props.divisions,
    },
    setup() {
        const columns = [
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
        header="Организации"
        :data="divisions"
        :columns
        :hasDelete="true"
        :hasEdit="true"
        :hasPaginate="true"
    />
</template>
