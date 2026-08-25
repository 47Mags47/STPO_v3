<script>
import { usePage } from '@inertiajs/vue3';
import { ResourceForm } from '@components';

export default {
    components:{
        ResourceForm,
    },
    computed: {
        law: () => usePage().props.law.data
    },
}
</script>

<template>
<ResourceForm
    header="Редактировать запись (закон)"
    method="PUT"
    :action="route('administrate.laws.update', { law: law.id })"
    :inputs="[
        {
            type: 'string',
            name: 'number',
            label: 'номер',
            value: law.number,
        },
        {
            type: 'text',
            name: 'name',
            label: 'Наименование',
            value: law.name,
        },
    ]"
/>
</template>
