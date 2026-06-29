<script>
import {
    VerticalForm,
    DatePicker,
    Select,
    ResourceTable
} from '@components'

export default {
    components: {
        VerticalForm,
        DatePicker,
        Select,
        ResourceTable
    }
}
</script>

<template>
    <VerticalForm>
        <template #content>
            <DatePicker name="DateInput" />
            <Select
                name="select"
                :hasSearch=false
                :options="
                    {
                        labelKey: 'label',
                        valueKey: 'value',
                        data: [
                            {
                                label: 'l1',
                                value: 'v1'
                            },
                            {
                                label: 'l2',
                                value: 'v2'
                            },
                            {
                                label: 'l3',
                                value: 'v3'
                            },
                            {
                                label: 'l4',
                                value: 'v4'
                            },
                        ]
                    }"
            />
        </template>
    </VerticalForm>
    <!-- <ResourceTable
        caption="ResourceForm"
        :hasCreateButton="true"
        :hasEditButton="true"
        :hasDeleteButton="true"
        :data="[
            {
                column1: 'Запись 1',
                column2: '2026-01-01',
            },
            {
                column1: 'Запись 2',
                column2: '2026-01-01',
            },
            {
                column1: 'Запись 3',
                column2: '2026-01-01',
            },
        ]"
        :collumns="[
            {
                title: 'Колонка 1',
                dataIndex: 'column1',
            },
            {
                type: 'date',
                title: 'Колонка 2',
                dataIndex: 'column2',
                width: '125px'
            },
        ]"
        :meta="{
            current_page: 1,
            from: 1,
            last_page: 1,
            links: [
                {
                    active: false,
                    label: 'pagination.previous',
                    page: null,
                    url: null,
                },
                {
                    active: true,
                    label: 1,
                    page: 1,
                    url: 'http://stpo.local/fsd/sfr-files?page=1',
                },
                {
                    active: false,
                    label: 'pagination.next',
                    page: null,
                    url: null,
                },
            ],
            path: 'http://stpo.local/fsd/sfr-files',
            per_page: 50,
            to: 1,
            total: 1,
        }"
        :rowLinks="[
            {
                'ico': 'x',
                'onClick': (row) => console.log(row)
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
                name: 'view.channel',
                event: '.change',
                onEvent: (e) => {
                    console.log(e);
                }
            }
        ]"
    /> -->
</template>
