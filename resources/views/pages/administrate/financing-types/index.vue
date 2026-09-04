<script>
import { ResourceTable } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },
    computed: {
        types: () => usePage().props.types,
    }
}
</script>

<template>
    <ResourceTable
        caption="Источники финансирования"
        :hasCreateButton="true"
        :hasEditButton="true"
        :hasDeleteButton="true"
        :data="types.data"
        :meta="types.meta"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
            {
                title: 'Наименование в ASP',
                dataIndex: 'asp_name',
            },
            {
                title: 'Код FSD',
                dataIndex: 'sfr_fsd_code',
                width: '100px',
            },
        ]"
    />
</template>
