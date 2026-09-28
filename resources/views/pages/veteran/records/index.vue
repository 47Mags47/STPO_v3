<script>
import { ResourceTable } from '@components'
import { router, usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },

    methods: {
        routeTo(routeObject){
            router.visit(routeObject)
        }
    },

    computed: {
        records: () => usePage().props.records,
        reportId: () => usePage().props.report_id,
    }
}
</script>

<template>
    <ResourceTable
        caption="Записи отчёта"
        :hasCreateButton="true"
        :hasDeleteButton="true"
        :data="records.data"
        :meta="records.meta"
        :rowLinks="[
            {
                color: 'blue',
                ico: 'pen',
                onClick: (row) => routeTo(route('veteran-work.records.edit', { report: reportId, record: row.id }))
            }
        ]"
        :collumns="[
            {
                title: 'Сотрудник',
                dataIndex: 'user.full_name',
            },
            {
                title: 'Подразделение',
                dataIndex: 'division.name',
            },
            {
                title: 'Всего',
                dataIndex: 'amount',
                width: '120px'
            },
            {
                title: 'электронный вид',
                dataIndex: 'online_form',
                width: '180px'
            },
            {
                title: 'МФЦ',
                dataIndex: 'MFC',
                width: '120px'
            },
        ]"
    />
</template>
