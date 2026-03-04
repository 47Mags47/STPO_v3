<script>
import { usePage } from "@inertiajs/vue3";
import ResourceTable from "../../../components/tables/ResourceTable.vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        files: () => usePage().props.files,
    },
    setup() {
        const columns = [
            {
                title: "Файл",
                dataIndex: "file.name",
            },
            {
                title: "Код региона",
                dataIndex: "region_code",
            },
            {
                title: "Признак вида представления информации",
                dataIndex: "sign_code",
            },
            {
                title: "Дата формирования файла",
                dataIndex: "in_date",
                type:"date"
            },
                        {
                title: "ПН файла",
                dataIndex: "npp_for_month",
            },
        ];
        return { columns };
    },
};
</script>

<template>
    <ResourceTable
        header="Федеральная социальная доплата"
        :columns
        :data="files"
        :hasCreate="true"
        :hasPaginate="true"
    />
</template>
