<script>
import { FileResourceTable } from "@components";
import { router, usePage } from "@inertiajs/vue3";

export default {
    components: {
        FileResourceTable,
    },
    computed: {
        files: () => usePage().props.files,
        bank: () => usePage().props.bank.data,
        event: () => usePage().props.event.data,
    },
    methods: {
        createButtonClickHandler(){
            router.post(route('payment.raports.store', {
                'event': this.event.id,
                'bank': this.bank.id,
            }))
        },
        downloadButtonClickHandler(file){
            window.open(route('payment.raports.show', {
                'event': this.event.id,
                'bank': this.bank.id,
                'raport': file.id
            }))
        }
    },
}
</script>
<template>
    <FileResourceTable
        caption="Выплаты (отчет на банк)"
        fileChannel="payment.raports"
        :hasErrorCollumn="false"
        :hasCreateButton="true"
        :onCreateButtonClick="createButtonClickHandler"
        :rowLinks="[
            {
                'visible': (row) => row.file.status.code === 'ok',
                'ico': 'download',
                'onClick': (file) => downloadButtonClickHandler(file)
            }
        ]"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Создан',
                type: 'datetime',
                dataIndex: 'created_at',
                width: '150px',
            },
        ]"
    />
</template>
