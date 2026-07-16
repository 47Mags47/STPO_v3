<script>
import { ResourceTable } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },
    computed: {
        payments: () => usePage().props.payments
    }
}
</script>

<template>
    <ResourceTable
        caption="Выплаты (реестры выплат)"
        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"
        :data="payments.data"
        :meta="payments.meta"
        :collumns="[
            {
                title: 'Код',
                dataIndex: 'code',
                width: '100px'
            },
            {
                title: 'КБК',
                dataIndex: 'kbk',
                width: '200px',
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
