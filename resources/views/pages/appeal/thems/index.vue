<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

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
                title: "Наименование",
                dataIndex: "name",
            },
            {
                title: "Группа",
                dataIndex: "group.name",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        header="Темы обращений"
        :columns
        :data="thems"
        :hasDelete="true"
        :hasEdit="true"
        :hasPaginate="true"
    />
</template>
