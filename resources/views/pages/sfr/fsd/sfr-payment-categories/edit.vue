<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        category: () => usePage().props.category.data,
    }
}
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Категория СФР)"
        method="PUT"
        :action="route('sfr.fsd.sfr-payment-categories.update', { sfr_payment_category: category.id })"
        :inputs="[
            {
                type: 'string',
                name: 'pay_number',
                label: 'Признак',
                value: category.pay_number
            },
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                value: category.name
            },
        ]"
    />
</template>
