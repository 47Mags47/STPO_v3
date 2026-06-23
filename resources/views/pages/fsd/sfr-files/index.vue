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
        :filters="[

            {
                type: 'checkbox',
                label: 'checkbox',
                name: 'checkbox'
            },
            {
                type: 'singleSelect',
                label: 'singleSelect',
                name: 'singleSelect2',
                options: [
                    {
                        label: 'label11223233213231',
                    },
                    {
                        label: 'label12',
                    },
                    {
                        label: 'label13',
                    },
                    {
                        label: 'label14',
                    },
                ]
            },
            {
                type: 'multiSelect',
                label: 'multiSelect',
                name: 'multiSelect',
                options: [
                    {
                        label: 'label11223233213231',
                    },
                    {
                        label: 'label12',
                    },
                    {
                        label: 'label13',
                    },
                    {
                        label: 'label14',
                    },
                ]
            },
            {
                type: 'dateFilter',
                label: 'singleDate',
                name: 'singleDate',
                rangeMode: false,
            },
            {
                type: 'numberBetween',
                label: 'numberBetween',
                name: 'numberBetween',
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
