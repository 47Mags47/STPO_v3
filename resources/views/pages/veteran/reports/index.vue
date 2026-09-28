<script>
import { ResourceTable } from '@components'
import { router, usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },

    methods: {
        getRowClasses(row) {
            let result = ''
            if(row.is_active)
                result = result + ' row-active'

            if(row.deleted_at)
                result = result + ' row-deleted'
            return result
        },

        routeTo(routeObject, params = {}, method = 'get') {
            router.visit(routeObject, {
                method: method,
                data: params,
            })
        },

        getDeleteAction(row) {
            const deleted = !!row.deleted_at

            return {
                color: deleted ? 'blue' : 'red',
                ico: deleted ? 'arrow-rotate-left' : 'trash',
                onClick: () => this.routeTo(route(
                        deleted
                            ? 'veteran-work.reports.restore'
                            : 'veteran-work.reports.destroy',
                        { report: row.id }
                    ),
                    {},
                    deleted ? 'patch' : 'delete'
                ),
                visible: !row.is_active
            }
        }
    },

    computed: {
        reports: () => usePage().props.reports
    }

    // HACK Добавить is_active
    // HACK поменять иконку на стрелочку
}
</script>

<template>
    <ResourceTable
        caption="Отчёты"
        :hasCreateButton="true"
        :data="reports.data"
        :meta="reports.meta"
        :rowLinks="[
            {
                color: 'blue',
                ico: 'arrow-big-up',
                onClick: (row) => routeTo(route('veteran-work.records.index', {report: row.id })),
                visible: (row) => !(!!row.deleted_at),
            },
            {
                color: 'blue',
                text: 'активировать',
                visible: (row) => !row.is_active && !(!!row.deleted_at),
                onClick: (row) => routeTo(route('veteran-work.reports.update', {report: row.id }), {
                    is_active: true
                }, 'put')
            },
            {
                color:   (row) => getDeleteAction(row).color,
                ico:     (row) => getDeleteAction(row).ico,
                onClick: (row) => getDeleteAction(row).onClick(),
                visible: (row) => getDeleteAction(row).visible
            }
        ]"
        :rowClasses="getRowClasses"
        :collumns="[
            {
                type: 'date',
                title: 'Дата отчёта',
                dataIndex: 'start_at',
            },
            {
                title: 'Всего',
                dataIndex: 'amount',
                width: '120px'
            },
            {
                title: 'Электронный вид',
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

<style lang="sass" scoped>
:deep(.table-content table tbody tr.row-deleted)
    background: var(--table-row-deleted-background-color)

    &:hover
        background: var(--table-row-deleted-background-color)

:deep(.table-content table tbody tr.row-active)
    background: var(--table-row-active-background-color)

    &:hover
        background: var(--table-row-active-background-color)
</style>
