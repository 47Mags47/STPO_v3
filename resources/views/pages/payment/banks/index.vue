<script>
import { ResourceTable } from "@components";
import { router, usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceTable,
    },

    computed: {
        banks: () => usePage().props.banks,
        event: () => usePage().props.event.data,
    },

    methods: {
        goToFilesButtonClickhandler(bank){
            router.get(route('payment.raports.index', {
                'event': this.event.id,
                'bank': bank.id
            }))
        }
    }
}
</script>
<template>
    <ResourceTable
        caption="Выплаты (Свод по банкам)"
        :data="banks.data"
        :meta="banks.meta"
        :actions="[
            {
                color: 'blue',
                ico: 'file-zipper',
                onClick: () => {}
            }
        ]"
        :rowLinks="[
            {
                'ico': 'file',
                'onClick': (bank) => goToFilesButtonClickhandler(bank)
            }
        ]"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
            {
                title: 'Файлов',
                dataIndex: 'payment-files.count',
                width: '100px',
            },
            {
                title: 'Организаций',
                dataIndex: 'payment-files.division_count',
                width: '100px',
            }
        ]"
    />
</template>
