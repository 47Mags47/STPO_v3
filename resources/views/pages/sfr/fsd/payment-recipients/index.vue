<script>
import { usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        recipients: () => usePage().props.recipients,
    },
}
</script>

<template>
    <ResourceTable
        caption="Федеральная социальная доплата (получатели выплат)"
        :data="recipients.data"
        :meta="recipients.meta"
        :collumns="[
            {
                title: 'СНИЛС',
                dataIndex: 'SNILS',
                width: '125px',
            },
            {
                title: 'Фамилия',
                dataIndex: 'last_name',
            },
            {
                title: 'Имя',
                dataIndex: 'first_name',
            },
            {
                title: 'Отчество',
                dataIndex: 'middle_name',
            },
            {
                title: 'Месяц',
                dataIndex: 'payment.in_month',
                type: 'date'
            },
            {
                headerColspan: 2,
                title: 'Выплата',
                dataIndex: 'payment.code',
            },
            {
                colspan: 0,
                dataIndex: 'payment.name',
            }
        ]"
    />
</template>
