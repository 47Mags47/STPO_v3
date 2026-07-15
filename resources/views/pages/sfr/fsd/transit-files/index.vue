<script>
import { router, usePage } from "@inertiajs/vue3";
import { FileResourceTable } from "@components";
import { route } from "ziggy-js";

export default {
    components: {
        FileResourceTable,
    },
    computed: {
        files: () => usePage().props.files,
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
        caption="Федеральная социальная доплата (Файлы проезда)"
        fileChannel="sfr.fsd.transit-files"
        :hasCreateButton="true"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Загружен',
                type: 'datetime',
                dataIndex: 'created_at',
                width: '150px'
            },
        ]"
    />
</template>
