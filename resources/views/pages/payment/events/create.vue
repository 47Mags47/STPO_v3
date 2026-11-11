<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        payments: () => usePage().props.payments.data
    }
}
</script>

<template>
<ResourceForm
    header="Новая запись (Календарь выплат)"
    sbm="Добавить"
    :action="route('payment.events.store')"
    :inputs="[
        {
            type: 'date',
            name: 'in_date',
            label: 'Дата',
        },
        {
            type: 'selectPopup',
            name: 'payment_id',
            label: 'Выплата',
            caption: 'Выплаты',
            url: route('api.administrate.payments.index'),
            hasSearchInput: true,
            columns: [
                {
                    title: 'Код',
                    dataIndex: 'code',
                    width: '150px'
                },
                {
                    title: 'КБК',
                    dataIndex: 'kbk',
                    width: '200px',
                },
                {
                    title: 'Наименование',
                    dataIndex: 'name',
                },
            ]
        },
    ]"
/>
</template>
