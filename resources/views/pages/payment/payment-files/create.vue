<script>
import { ResourceForm } from "@components";
import { usePage } from "@inertiajs/vue3";

export default {
    components: {
        ResourceForm
    },
    computed: {
        banks: () => usePage().props.banks.data,
        event: () => usePage().props.event.data
    }
}
</script>

<template>
    <ResourceForm
        header="Новая запись (Файл)"
        sbm="Добавить"
        :action="route('payment.payment-files.store', { event: event.id })"
        :inputs="[
            {
                type: 'selectPopup',
                name: 'bank_id',
                label: 'Банк',
                caption: 'Банки',
                url: route('api.administrate.banks.index'),
                hasSearchInput: true,
                columns: [
                    {
                        title: 'Код',
                        dataIndex: 'code',
                        width: '150px'
                    },
                    {
                        title: 'Номер',
                        dataIndex: 'number',
                        width: '150px',
                    },
                    {
                        title: 'Наименование',
                        dataIndex: 'name',
                    },
                ]
            },
            {
                type: 'bigFiles',
                name: 'file_ids',
                label: 'Файл',
            },
        ]"
    />
</template>
