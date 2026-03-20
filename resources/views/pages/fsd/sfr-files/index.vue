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
        :meta="files.meta"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Загружен',
                type: 'date',
                dataIndex: 'upload_at',
                width: '100px'
            }
        ]"
    />
</template>
