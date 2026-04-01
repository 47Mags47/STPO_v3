<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";
import { h } from "vue";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        files: () => usePage().props.files,
    },
}
</script>

<template>
    <ResourceTable
        caption="Федеральная социальная доплата (реестры выплат)"

        :hasCreateButton="true"
        :data="files.data"
        :meta="files.meta"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Записей',
                dataIndex: 'payments.count',
                width: '100px',
                position: 'center-right'
            },
            {
                type: 'render',
                // HACK Поправить формат вывода даты на xx.xx.xxxx
                render: (row) => ({ component:  'span', props: { innerHTML: `${row.date_start} - ${row.date_end}`} })
            },
        ]"
    />
</template>
