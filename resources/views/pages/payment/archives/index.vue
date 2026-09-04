<script>
import { FileResourceTable } from "@components";
import { router, usePage } from "@inertiajs/vue3";

export default {
    components: {
        FileResourceTable,
    },
    computed: {
        files: () => usePage().props.files,
        event: () => usePage().props.event.data,
    },
    methods: {
        createButtonClickHandler(){
            router.post(route('payment.archives.store', {
                'event': this.event.id,
            }))
        },
        downloadButtonClickHandler(file){
            window.open(route('payment.archives.show', {
                'event': this.event.id,
                'archive': file.id
            }))
        }
    },
}
</script>
<template>
    <FileResourceTable
        caption="Выплаты (отчет по выплате)"
        fileChannel="payment.archives"
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
