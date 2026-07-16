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
            type: 'datePicker',
            name: 'in_day',
            label: 'Дата',
        },
        {
            type: 'select',
            name: 'payment_id',
            label: 'Выплата',
            options: payments,
        },
    ]"
/>
</template>
