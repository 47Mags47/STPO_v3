<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        files: () => usePage().props.files,
    },
};
</script>

<template>
    <ResourceTable
        caption="Федеральная социальная доплата"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"

        :data="files.data"
        :meta="divisions.meta"
        :collumns="[
            {
                title: 'Файл',
                dataIndex: 'file.name',
            },
            {
                title: 'Код региона',
                dataIndex: 'region_code',
            },
            {
                title: 'Признак вида представления информации',
                dataIndex: 'sign_code',
            },
            {
                title: 'Дата формирования файла',
                dataIndex: 'in_date',
                type:'date'
            },
                        {
                title: 'ПН файла',
                dataIndex: 'npp_for_month',
            },
        ]"
    />
</template>
