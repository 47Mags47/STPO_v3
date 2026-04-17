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
            // HACK выводить название месяца, а не дату
            {
                title: 'На месяц',
                // type: 'date',
                dataIndex: 'in_month',
            }
        ]"
    />
</template>
