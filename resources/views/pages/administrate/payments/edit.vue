<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        payment: () => usePage().props.payment.data
    }
}
</script>

<template>
<ResourceForm
    header="Редактировать запись (выплата)"
    method="PUT"
    :action="route('administrate.payments.update', { payment: payment.id })"
    :inputs="[
        {
            type: 'string',
            name: 'code',
            label: 'Код',
            value: payment.code,
        },
        {
            type: 'number',
            name: 'kbk',
            label: 'КБК',
            value: payment.kbk,
        },
        {
            type: 'string',
            name: 'name',
            label: 'Наименование',
            value: payment.name,
        },
    ]"
/>
</template>
