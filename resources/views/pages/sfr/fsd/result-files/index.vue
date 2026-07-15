<script>
import { router, usePage } from "@inertiajs/vue3";
import { FileResourceTable } from "@components";
import { route } from "ziggy-js";

export default {
    components: {
        FileResourceTable,
    },
    computed: {
        SFRFile: () => usePage().props.SFRFile.data,
    },
    methods: {
        createButtonClickHandler(){
            router.post(route('sfr.fsd.result-files.store', {'SFRFile': this.SFRFile.id}))
        },

        downloadButtonClickHandler(file){
            window.open(route('sfr.fsd.result-files.show', {
                'SFRFile': this.SFRFile.id,
                'result_file': file.id
            }))
        }
    },
};
</script>

<template>
    <FileResourceTable
        caption="Федеральная социальная доплата (Отчётные файлы)"
        fileChannel="sfr.fsd.result-files"
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
                type: 'date',
                format: 'dd.MM.yyyy HH:mm',
                title: 'Создан',
                dataIndex: 'created_at',
                width: '135px'
            },
            {
                title: 'Наименование',
                dataIndex: 'name',
            },
        ]"
    />
</template>
