<script>
import { ResourceTable } from '@components'
import { usePage } from '@inertiajs/vue3';
import { DateTime } from 'luxon';

export default {
    components: {
        ResourceTable
    },

    computed: {
        date: () => usePage().props.date.data,
        reports: () => usePage().props.reports,
        dateString() {
            return DateTime.fromISO(this.date.in_date).setLocale('ru').toFormat('dd.MM.yyyy')
        }
    }
}
</script>

<template>
    <ResourceTable
        :caption="`отчет на ${ dateString }`"
        :hasDeleteButton="true"
        :data="reports.data"
        :meta="reports.meta"
        :columns="[
            {
                title: 'Территория',
                dataIndex: 'division.name'
            },
            {
                title: 'Всего',
                dataIndex: 'all'
            },
            {
                title: 'В эл. виде',
                dataIndex: 'online'
            },
            {
                title: 'через МФЦ',
                dataIndex: 'MFC'
            },
        ]"
    />
</template>
