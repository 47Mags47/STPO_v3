<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        payment: () => usePage().props.payment.data,
        laws: () => usePage().props.laws.data
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
        {
            type: 'select',
            name: 'law_id',
            label: 'Закон',
            options: laws,
            value: payment.law
        }
    ]"
/>
</template>
