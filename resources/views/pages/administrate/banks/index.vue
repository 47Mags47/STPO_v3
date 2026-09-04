<script>
import { ResourceTable } from '@components'
import { usePage } from '@inertiajs/vue3';

export default {
    components: {
        ResourceTable
    },
    computed: {
        banks: () => usePage().props.banks
    }
}
</script>

<template>
    <ResourceTable
        caption="Банки"
        :hasCreateButton="true"
        :hasDeleteButton="true"
        :hasEditButton="true"
        :data="banks.data"
        :meta="banks.meta"
        :collumns="[
            {
                title: 'Код',
                dataIndex: 'code',
                width: '100px'
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
