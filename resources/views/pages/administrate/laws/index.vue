<script>
import { ResourceTable } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },
    computed: {
        laws: () => usePage().props.laws
    }
}
</script>

<template>
    <ResourceTable
        caption="Законы"
        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"
        :data="laws.data"
        :meta="laws.meta"
        :collumns="[
            {
                title: 'Номер',
                dataIndex: 'number',
                width: '125px'
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
