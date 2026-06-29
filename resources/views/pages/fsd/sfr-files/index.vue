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
                'ico': 'file',
                'onClick': (row) => router.visit(route('fsd.payment-files.index', {'sfrFile': row.id}))
            },
            {
                'ico': 'download',
                'onClick': (row) => router.visit(route('fsd.sfr-files.show', {'sfr_file': row.id}))
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
