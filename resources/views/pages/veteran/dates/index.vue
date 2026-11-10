<script>
import { ResourceTable } from '@components'
import { router, usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },

    data(){
        return {
            router
        }
    },

    computed: {
        dates: () => usePage().props.dates,
    }
}
</script>

<template>
    <ResourceTable
        caption="Даты отчета"
        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasShowButton="true"
        :data="dates.data"
        :meta="dates.meta"
        :row-classes="(row) => {
            if (row.is_active)
                return 'row-active'
            return ''
        }"
        :columns="[
            {
                type: 'date',
                title: 'Дата',
                dataIndex: 'in_date'
            },
            {
                type: 'bool',
                title: 'Активно',
                dataIndex: 'is_active'
            }
        ]"
        :rowLinks="[
            {
                ico: 'pen',
                onClick: (date) => router.put(route('veteran.dates.update', { date:date.id }), { is_active: !date.is_active })
            }
        ]"
    />
</template>
