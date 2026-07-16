<script>
import { router, usePage } from "@inertiajs/vue3";
import { FileResourceTable } from "@components";
import { route } from "ziggy-js";

export default {
    components: {
        FileResourceTable,
    },
    data(){
        return {
            router,
        }
    }
};
</script>

<template>
    <FileResourceTable
        caption="Федеральная социальная доплата (Запросы СФР)"
        fileChannel="sfr.fsd.sfr-files"
        :hasCreateButton="true"
        :rowLinks="[
            {
                'ico': 'file',
                'onClick': (file) => router.visit(route('sfr.fsd.result-files.index', { 'SFRFile': file.id }))
            }
        ]"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                type: 'date',
                title: 'Дата начала',
                dataIndex: 'date_start',
                width: '100px'
            },
            {
                type: 'date',
                title: 'Дата окончания',
                dataIndex: 'date_end',
                width: '100px'
            },
        ]"
    />
</template>
