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
    header="Редактировать запись (Категория проезда)"
    method="PUT"
    :action="route('sfr.fsd.transit-categories.update', { transit_category: category.id })"
    :inputs="[
        {
            type: 'string',
            name: 'wp_category_id',
            label: 'wp ID',
            value: category.wp_category_id
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
