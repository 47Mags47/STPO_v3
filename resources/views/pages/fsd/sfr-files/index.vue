<script>
import { router, usePage } from "@inertiajs/vue3";
import { ResourceTable } from "@components";
import { route } from "ziggy-js";

export default {
    components: {
        ResourceTable,
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
    <ResourceTable
        caption="Федеральная социальная доплата (реестры СФР)"
        :hasCreateButton="true"
        :data="files.data"
        :meta="files.meta"
        :rowLinks="[
            {
                'ico': 'faFile',
                'onClick': (row) => router.visit(route('fsd.payment-files.index', {'sfrFile': row.id}))
            },
            {
                'ico': 'faDownload',
                'onClick': (row) => router.visit(route('fsd.sfr-files.show', {'sfr_file': row.id}))
            }
        ]"
        :collumns="[
            {
                title: 'Наименование',
                dataIndex: 'file.name',
            },
            {
                title: 'Начало',
                dataIndex: 'recipients.min_date_start',
                type: 'date',
                width: '100px',
            },
            {
                title: 'Окончание',
                dataIndex: 'recipients.max_date_start',
                type: 'date',
                width: '100px',
            },
            {
                title: 'Получателей',
                dataIndex: 'recipients.count',
                width: '100px',
                position: 'center-right'
            },
            {
                title: 'Загружен',
                type: 'date',
                dataIndex: 'upload_at',
                width: '100px'
            },
        ]"
        :channels="[
            {
                name: 'sfr.fsd.sfr-file',
                event: '.change',
                onEvent: (e) => {
                    router.reload({ only: ['files'] })
                }
            }
        ]"
    />
</template>
