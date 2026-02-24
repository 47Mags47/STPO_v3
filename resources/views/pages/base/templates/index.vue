<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        templates: () => usePage().props.templates,
    },
    setup() {
        const columns = [
            {
                title: "Наименование",
                dataIndex: "name",
            },
            {
                title: "Вид",
                dataIndex: "style.name",
            },
            {
                title: "Тип",
                dataIndex: "type.name",
            },
            {
                title: "Разбивать",
                dataIndex: "chunk",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        header="Организации"
        :columns
        :data="templates"
        :hasDelete="true"
        :hasEdit="true"
        :hasPaginate="true"
    />
</template>
