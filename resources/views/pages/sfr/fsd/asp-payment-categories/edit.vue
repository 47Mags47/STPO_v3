<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        category: () => usePage().props.category.data,
        sfr_categories: () => usePage().props.sfr_categories,
    }
}
</script>

<template>
    <ResourceForm
        header="Редактировать запись (Категория АСП)"
        method="PUT"
        :action="route('sfr.fsd.asp-payment-categories.update', { asp_payment_category: category.id })"
        :inputs="[
            {
                type: 'string',
                name: 'name',
                label: 'Наименование',
                value: category.name
            },
            {
                type: 'select',
                name: 'sfr_payment_category_id',
                label: 'Категория СФР',
                options: sfr_categories.data,
                value: category.sfr_category
            },
        ]"
    />
</template>
