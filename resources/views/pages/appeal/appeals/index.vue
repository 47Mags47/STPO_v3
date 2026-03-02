<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        appeals: () => usePage().props.appeals,
    },
    setup() {
        const columns = [
            {
                title: "Кабинет",
                dataIndex: "office",
            },
            {
                title: "Комментарий",
                dataIndex: "comment",
            },
            {
                title: "Заявитель",
                dataIndex: "sender.full_name",
            },
            {
                title: "Тема",
                dataIndex: "them.name",
            },
            {
                title: "Статус",
                dataIndex: "status.name",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        header="Заявки"
        :columns
        :data="appeals"
        :hasCreate="true"
        :hasPaginate="true"
    />
</template>
