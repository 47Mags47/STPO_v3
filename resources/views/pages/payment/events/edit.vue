<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        event: () => usePage().props.event.data,
        payments: () => usePage().props.payments.data
    }
}
</script>

<template>
<ResourceForm
    header="Редактировать запись (Календарь выплат)"
    method="PUT"
    :action="route('payment.events.update', { event: event.id })"
    :inputs="[
        {
            type: 'date',
            name: 'in_day',
            label: 'Дата',
            value: event.in_day
        },
        {
            type: 'select',
            name: 'payment_id',
            label: 'Выплата',
            options: {
                labelKey: 'name',
                valueKey: 'id',
                data: payments,
            },
            value: event.payment.id
        },
    ]"
/>
</template>
