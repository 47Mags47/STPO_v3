<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";
import List from "../../../components/List/List.vue";

export default {
    components: {
        ResourceTable,
        List,
    },
    computed: {
        moduls: () => usePage().props.moduls,
    },
    setup() {
        const columns = [
            {
                title: "Наименование",
                dataIndex: "name",
            },
            {
                title: "Наименование роута",
                dataIndex: "route_name",
            },
            {
                title: "Группа",
                dataIndex: "group.name",
            },
            {
                title: "Создатель",
                dataIndex: "creator_id",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        header="Модули"
        :columns
        :data="moduls"
        :hasDelete="true"
        :hasEdit="true"
        :hasPaginate="true"
    />
</template>
