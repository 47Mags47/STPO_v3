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
}
</script>

<template>
    <ResourceTable
        caption="Федеральная социальная доплата (реестры выплат)"

        :hasCreateButton="true"
        :hasDeleteButton="true"
        :data="files.data"
        :meta="files.meta"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Наименование выплаты',
                dataIndex: 'type.name',
                width: '600px',
            },
            {
                title: 'Тип',
                dataIndex: 'type.pay_code',
                width: '50px',
            },
            // HACK выводить название месяца, а не дату
            {
                title: 'Месяц',
                dataIndex: 'in_month',
                width: '150px',
            },
            {
                title: 'Записей',
                dataIndex: 'payments.count',
                width: '75px',
                position: 'center-right'
            },
        ]"
    />
</template>
