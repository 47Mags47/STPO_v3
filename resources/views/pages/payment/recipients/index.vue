<script>
import { ResourceTable } from "@components";
import { usePage } from "@inertiajs/vue3";
import { DateTime } from "luxon";

export default {
    components: {
        ResourceTable,
    },
    computed: {
        recipients: () => usePage().props.recipients,
    },
    methods: {
        getHumanDate: (date) => DateTime.fromISO(date).setLocale('ru').toFormat('dd.MM.yyyy')
    }
}
</script>

<template>
    <ResourceTable
        caption="Выплаты (Получатели)"
        :data="recipients.data"
        :meta="recipients.meta"
        :collumns="[
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
                type: 'date',
                title: 'ДР',
                dataIndex: 'd_rojd',
                width: '100px'
            },
            {
                title: 'СНИЛС',
                dataIndex: 'SNILS',
                width: '120px'
            },
            {
                title: 'Счет',
                dataIndex: 'account',
                width: '160px'
            },
            {
                title: 'Сумма',
                dataIndex: 'amount',
                width: '80px'
            },
            {
                title: 'Паспорт',
                type: 'render',
                width: '110px',
                render: (recipient) => ({
                    component: 'p',
                    props: {
                        innerHTML: `${recipient.p_series} ${recipient.p_number}`
                    }
                })
            },
            {
                title: 'Выдан',
                type: 'render',
                width: '600px',
                render: (recipient) => ({
                    component: 'p',
                    props: {
                        innerHTML: `${getHumanDate(recipient.p_date)}<br>${recipient.p_div}`
                    }
                })
            },
        ]"
    />
</template>
